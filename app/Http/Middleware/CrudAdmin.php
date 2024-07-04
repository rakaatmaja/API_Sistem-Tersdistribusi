<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CrudAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $currentUser = Auth::user();
        // $konten = Data_Konten::findOrFail($request->id);

        // Cek apakah kategori user bukan admin
        if ($currentUser->category !== 'admin') {
            // Jika bukan admin, kembalikan respon dengan pesan error
            return response()->json(['error' => 'Anda tidak memiliki izin mengubah konten ini'], 403);
        }

        // Jika admin, lanjutkan ke permintaan berikutnya
        return $next($request);
    }
}
