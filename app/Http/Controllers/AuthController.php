<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan form login petugas/admin.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login petugas/admin (pakai username).
     */
    public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => ['required'],
        'password' => ['required'],
    ]);

    if (Auth::attempt([
        'username' => $credentials['username'],
        'password' => $credentials['password'],
    ])) {

        $request->session()->regenerate();

        switch (auth()->user()->role) {

            case 'provinsi':
                return redirect()->route('dashboard.provinsi');

            case 'kabupaten':
                return redirect()->route('dashboard.kabupaten');

            case 'kecamatan':
                return redirect()->route('dashboard.kecamatan');

            case 'kelurahan':
                return redirect()->route('dashboard.kelurahan');

            case 'warga':
                return redirect()->route('dashboard.warga');

            default:
                Auth::logout();

                return back()->withErrors([
                    'username'=>'Role tidak dikenali.'
                ]);
        }
    }

    return back()->withErrors([
        'username'=>'Username atau Password salah.'
    ]);
}
    /**
     * Tampilkan form login warga.
     */
    public function showLoginWarga()
    {
        return view('auth.login-warga');
    }

    /**
     * Proses login warga (pakai NIK).
     */
    public function loginWarga(Request $request)
    {
        $credentials = $request->validate([
            'nik' => ['required', 'string', 'size:16'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt([
            'nik' => $credentials['nik'],
            'password' => $credentials['password'],
            'role' => 'warga',
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'nik' => 'NIK atau password salah.',
        ])->onlyInput('nik');
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}