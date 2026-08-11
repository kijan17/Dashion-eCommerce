<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite; // Tambahkan ini untuk Socialite

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    /**
     * Menampilkan halaman form registrasi.
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.register');
    }

    /**
     * PROSES LOGIN BIASA
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'owner') {
                return redirect()->intended('dashboard')->with('success', 'Selamat datang Owner!');
            } elseif ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Halo Admin, Selamat Bekerja!');
            } else {
                return redirect()->intended('/')->with('success', 'Login berhasil! Selamat berbelanja.');
            }
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    /**
     * PROSES REGISTER BIASA
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => 'pembeli',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * PROSES LOGOUT
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda berhasil logout!');
    }

    /**
     * Redirect user ke halaman login Google. (Sesuai Modul Anda)
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Menangani callback dari Google setelah user login. (Sesuai Modul Anda)
     */
    public function handleGoogleCallback()
    {
        try {
            // Ambil user dari Google (gunakan stateless agar tidak error di localhost)
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Cari user berdasarkan email atau google_id
            $user = User::where('email', $googleUser->email)
                        ->orWhere('google_id', $googleUser->id)
                        ->first();

            if ($user) {
                // Jika user sudah ada, update google_id jika belum ada, lalu login
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
                
                Auth::login($user);
                
                // Redirect sesuai role
                if ($user->role === 'owner') {
                    return redirect()->intended('dashboard');
                } elseif ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->intended('/');
                }

            } else {
                // Jika user belum ada, buat akun baru (Otomatis jadi Pembeli)
                $newUser = User::create([
                    'username' => strtolower(str_replace(' ', '', $googleUser->name)) . rand(10, 99),
                    'email'    => $googleUser->email,
                    'google_id'=> $googleUser->id,
                    'password' => Hash::make('password_google_dummy_123'), 
                    'role'     => 'pembeli',
                ]);

                Auth::login($newUser);
                
                return redirect()->intended('/');
            }

        } catch (\Exception $e) {
            // Tangkap error jika login gagal
            // JIKA cURL error 77 muncul lagi, MAKA MASALAHNYA ADALAH CONFIG LARAGON/PHP.
            return redirect()->route('login')->with('error', 'Login Google Gagal: ' . $e->getMessage());
        }
    }
}