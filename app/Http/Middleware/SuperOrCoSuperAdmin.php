<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperOrCoSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->canManageUsers()) {
            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak. Fitur ini hanya dapat diakses oleh Super Admin dan Co-Super Admin.');
        }

        return $next($request);
    }
}
