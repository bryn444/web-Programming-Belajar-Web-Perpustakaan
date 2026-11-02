<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Temukan pengguna berdasarkan email
        $user = User::where('email', $credentials['email'])->first();

        if ($user) {
            // Periksa apakah pengguna aktif
            if ($user->is_active != 1) {
                return back()->with('error', 'Akun Anda tidak aktif.');
            }

            // Coba login
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('admin/dashboard');
            }
        }

        return back()->with('error', 'Login gagal. Periksa kembali Email dan Password');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah logout.');
    }

    public function registerMember(Request $request)
    {
        $messages = [
            'nama.required' => 'Nama lengkap harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus berformat email yang benar.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'konfirmasi_password.required' => 'Konfirmasi Password harus diisi.',
            'konfirmasi_password.min' => 'Konfirmasi Password minimal 8 karakter.',
            'konfirmasi_password.same' => 'Password dan konfirmasi password tidak cocok.',
        ];

        $request->validate([
            'nama' => 'required|string|max:128',
            'alamat' => 'required',
            'email' => 'required|string|email|max:128|unique:users',
            'password' => 'required|string|min:8',
            'konfirmasi_password' => 'required|string|min:8|same:password',
        ], $messages);

        User::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'image' => 'profil-pic/default.jpg',
            'password' => Hash::make($request->password),
            'role_id' => 2, // assuming 2 is the default role for users
            'is_active' => 1, // assuming new users are active by default
        ]);

        return response()->json([
            'success' => 'Akun berhasil didaftarkan. Silakan login.'
        ]);
    }

    public function loginMember(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Temukan pengguna berdasarkan email
        $user = User::where('email', $credentials['email'])->first();

        if ($user) {
            // Periksa apakah pengguna aktif
            if ($user->is_active != 1) {
                return back()->with('error', 'Akun Anda tidak aktif.');
            }

            // Periksa apakah pengguna adalah member
            if ($user->role_id != 2) {
                return back()->with('error', 'Anda harus login sebagai member.');
            }

            // Coba login
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/')->with('success', 'Berhasil login.');
            }
        }

        return back()->with('error', 'Login gagal. Periksa kembali Email dan Password.');
    }
}