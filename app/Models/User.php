<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isCoSuperAdmin(): bool
    {
        return $this->role === 'co_super_admin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAdminIkada(): bool
    {
        return $this->role === 'admin_ikada';
    }

    /**
     * Menentukan apakah user berhak mengelola data profil IKADA UI.
     */
    public function canManageIkada(): bool
    {
        return in_array($this->role, ['super_admin', 'co_super_admin', 'admin_ikada']);
    }

    /**
     * Menentukan apakah user berhak mengakses modul manajemen akun pengelola (Read/List).
     * Super Admin dan Co-Super Admin berhak melihat daftar akun. Admin biasa dan Admin IKADA dilarang.
     */
    public function canManageUsers(): bool
    {
        return in_array($this->role, ['super_admin', 'co_super_admin']);
    }

    /**
     * Menentukan apakah user berhak menambah, mengedit, atau menghapus akun pengelola.
     * HANYA Super Admin yang berhak memodifikasi akun. Co-Super Admin berstatus Read-Only.
     */
    public function canModifyUsers(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Menentukan apakah user berhak menghapus akun.
     */
    public function canDeleteUsers(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Menentukan apakah user berhak mengakses modul Struktur Organisasi.
     * Hanya Super Admin dan Co-Super Admin. Admin biasa dan Admin IKADA dilarang.
     */
    public function canAccessStructure(): bool
    {
        return in_array($this->role, ['super_admin', 'co_super_admin']);
    }

    public function getRoleBadgeAttribute(): string
    {
        return match ($this->role) {
            'super_admin' => 'Super Admin',
            'co_super_admin' => 'Co-Super Admin',
            'admin_ikada' => 'Admin IKADA UI',
            'admin' => 'Admin Biasa',
            default => ucfirst($this->role),
        };
    }
}
