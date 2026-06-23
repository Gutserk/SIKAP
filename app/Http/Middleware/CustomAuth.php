<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomAuth
{
    public function handle(Request $request, Closure $next)
    {
        $email = $request->header('x-bbsso-sus-usr');

        if (!$email) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $guard = Auth::guard('admin');

        if (session('admin_email') && session('admin_email') !== $email) {
            $request->session()->flush();
            $guard->logout();
        }

        $admin = Admin::where('email', $email)->first();

        if (!$admin) {
            return response()->json(['message' => 'Unauthorized: admin tidak ditemukan'], 461);
        }

        session([
            'admin_id'    => $admin->id,
            'admin_nama'  => $admin->nama_lengkap,
            'admin_email' => $admin->email,
            'logged_in'   => true,
        ]);

        if (!$guard->check() || $guard->id() !== $admin->id) {
            $guard->login($admin);
        }

        return $next($request);
    }
}
