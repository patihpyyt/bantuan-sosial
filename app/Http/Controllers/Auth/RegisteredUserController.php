<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
                $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'size:16', 'unique:users,nik'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
$user = User::create([
    'nama_lengkap' => $request->nama_lengkap,
    'nik' => $request->nik,
    'username' => $request->nik,
    'password' => Hash::make($request->password),
    'role' => 'warga',
    'kode_desa' => '00000', // atau ambil dari $request->kode_desa kalau form-nya punya field ini
    'aktif' => 1,
]);

       event(new Registered($user));

// Auth::login($user);  // hapus atau komentari baris ini

return redirect()->route('login')->with('status', 'Registrasi berhasil, silakan login.');
    }
}
