<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdmissionSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_id',
        'is_open',
        'requirements',
        'required_documents',
        'schedule_information',
        'additional_information',
        'whatsapp_template',
        'steps',
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'steps' => 'array',
    ];

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function getFormattedStepsAttribute(): array
    {
        if (!empty($this->steps) && is_array($this->steps)) {
            return $this->steps;
        }

        return [
            [
                'title' => 'Pendaftaran Awal',
                'description' => 'Hubungi panitia via WhatsApp atau sekretariat untuk mengisi formulir pendaftaran.',
                'icon' => 'document',
            ],
            [
                'title' => 'Ujian & Seleksi',
                'description' => 'Mengikuti tes baca Al-Qur\'an, tes kemampuan akademik dasar, dan wawancara santri & wali.',
                'icon' => 'academic',
            ],
            [
                'title' => 'Pengumuman Kelulusan',
                'description' => 'Pengumuman hasil seleksi disampaikan secara transparan via portal resmi dan WhatsApp.',
                'icon' => 'megaphone',
            ],
            [
                'title' => 'Daftar Ulang & Masuk',
                'description' => 'Penyelesaian administrasi, penyerahan berkas fisik, dan santri mulai menetap di asrama Dayah.',
                'icon' => 'check',
            ],
        ];
    }
}
