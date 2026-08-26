<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!$request->user()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('login');
        }

        // 2. Jika tidak ada parameter role yang ditentukan, izinkan request lewat
        if (empty($roles)) {
            return $next($request);
        }

        // 3. Normalisasi daftar role yang diperbolehkan (support format: 'Admin', 'Petugas' atau 'Admin|Petugas' atau 'Admin,Petugas')
        $allowedRoles = [];
        foreach ($roles as $role) {
            foreach (preg_split('/[,|]/', $role) as $r) {
                $trimmed = trim($r);
                if ($trimmed !== '') {
                    $allowedRoles[] = strtolower($trimmed);
                }
            }
        }

        // 4. Cek role user saat ini (case-insensitive)
        $userRole = strtolower(trim((string) $request->user()->role));

        if (!in_array($userRole, $allowedRoles, true)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
