<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\UserUmum;
use App\Models\Admin;
use App\Models\PembayaranSertifikasi;
use App\Models\PendaftarsnSeminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private array $types = [
        'student' => [
            'label' => 'Mahasiswa',
            'model' => Mahasiswa::class,
            'identity' => ['npm', 'email'],
            'identityPlaceholder' => 'NPM',
            'note' => 'Login mahasiswa',
        ],

        'lecturer' => [
            'label' => 'Dosen',
            'model' => Dosen::class,
            'identity' => ['nidn', 'email'],
            'identityPlaceholder' => 'NIDN / Email',
            'note' => 'Login dosen',
        ],

        'public' => [
            'label' => 'Umum',
            'model' => UserUmum::class,
            'identity' => ['email'],
            'identityPlaceholder' => 'Email',
            'note' => null,
        ],
    ];

    public function login()
    {
        return view('auth.choose');
    }

    public function showLoginForm(Request $request, string $type)
    {
        if (!isset($this->types[$type])) {
            return redirect()->route('login.choose');
        }

        $config = $this->types[$type];

        return view('auth.login', [
            'title' => 'Masuk ' . $config['label'],
            'identityPlaceholder' => $config['identityPlaceholder'],
            'type' => $type,
            'note' => $config['note'],
        ]);
    }

 public function authenticate(Request $request)
    {
        $request->validate([
            'identity' => 'required',
            'password' => 'required',
            'type' => 'required',
        ]);
        $config = $this->types[$request->type];
        $query = $config['model']::query();

        foreach ($config['identity'] as $i => $field) {
            $i === 0
                ? $query->where($field, $request->identity)
                : $query->orWhere($field, $request->identity);
        }
        $user = $query->first();

        if (!$user || !$this->checkPassword($request->password, $user->password)) {
            return back()
                ->withErrors(['identity' => 'Login gagal'])
                ->with('error', 'Login gagal, silakan periksa kembali kredensial Anda.')
                ->withInput();
        }

        // Clear admin session jika ada
        session()->forget(['admin_id', 'admin_name']);
        
        session([
            'auth_user' => [
                'id' => $user->id,
                'name' => $user->nama ?? $user->name,
                'email' => $user->email,
                'role' => $request->type,
                'pasfoto' => $user->pasfoto, // Tambahkan ini!
            ]
        ]);
        return redirect()->route('home')
                ->with('success', 'Selamat datang kembali!')
                ->with('user_name', $user->nama ?? $user->name);
    }    
    public function showLoginAdmin()
    {
        return view('auth.adminlogin');
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)
        ->where('password', $request->password)
        ->first();

        if (!$admin) {
            return back()
                ->with('error', 'Username atau password salah')
                ->withInput();
        }

        // Clear user session jika ada
        session()->forget('auth_user');
        
        session([
            'admin_id' => $admin->id,
            'admin_name' => $admin->nama
        ]);

    return redirect()->route('admin.dashboard')->with('success', 'Login berhasil! Selamat datang kembali.');    }

    public function logoutAdmin()
    {
        session()->forget('admin_id');
        session()->forget('admin_name');

        return redirect('');
    }

    // Menampilkan halaman registrasi
    public function showRegisterForm()
    {
        return view('auth.umumregister', [
            'title' => 'Daftar Akun Umum',
            'type' => 'public'
        ]);
    }

    // Memproses input registrasi
    public function registerPublic(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:user_umum,email',
            'password' => 'required|min:6',
            'no_hp'    => 'nullable|string',
        ]);

        UserUmum::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Hash password agar aman
            'no_hp'    => $request->no_hp,
        ]);

        return redirect()->route('login.public')
                        ->with('success', 'Akun berhasil dibuat, silakan login.');
    }

    public function profile()
    {
        // 1. Cek Sesi Login
        if (!session()->has('auth_user')) {
            return redirect()->route('login.choose');
        }

        $authUser = session('auth_user');
        $role = $authUser['role'];
        $id = $authUser['id'];

        // 2. Ambil data lengkap user
        $config = $this->types[$role] ?? null;
        if (!$config) {
            return redirect()->route('login.choose');
        }
        $user = $config['model']::find($id);

        // 3. Logika Looping pasfoto
        $filename = 'default.png';
        $photoCandidates = [];

        if (!empty($user->pasfoto)) {
            $photoCandidates[] = strtolower($user->pasfoto);
        }

        if (!empty($user->email)) {
            $email = strtolower($user->email);
            [$localPart, $domain] = array_pad(explode('@', $email, 2), 2, '');
            $localPart = preg_replace('/[^a-z0-9]+/', '', $localPart);
            $cleanDomain = preg_replace('/[^a-z0-9]+/', '', $domain);
            $cleanDomainName = preg_replace('/[^a-z0-9]+/', '', explode('.', $domain)[0] ?? '');
            $hyphenDomain = trim(preg_replace('/[^a-z0-9]+/', '-', $domain), '-');

            if ($localPart !== '') {
                $photoCandidates[] = $localPart;
                if ($cleanDomainName !== '') {
                    $photoCandidates[] = $localPart . '-' . $cleanDomainName;
                    $photoCandidates[] = $localPart . '-' . $hyphenDomain;
                }
                if ($cleanDomain !== '') {
                    $photoCandidates[] = $localPart . $cleanDomain;
                }
            }
        }
        if (!empty($user->npm)) {
            $photoCandidates[] = strtolower(preg_replace('/[^a-z0-9]+/', '', $user->npm));
        }
        if (!empty($user->nama)) {
            $photoCandidates[] = strtolower(preg_replace('/[^a-z0-9]+/', '', $user->nama));
        }
        
        foreach (array_unique($photoCandidates) as $candidate) {
            foreach (['png', 'jpg', 'jpeg'] as $ext) {
                $checkName = $candidate . '.' . $ext;
                if (file_exists(public_path('images/pasfoto/' . $checkName))) {
                    $filename = $checkName;
                    break 2;
                }
            }
        }

        // 4. Integrasi Data Pembayaran Sertifikasi
        $pembayarans = PembayaranSertifikasi::with('sertifikasi')
            ->where('user_id', $id)
            ->where('user_type', $role)
            ->get();

        // 5. Integrasi Data Pendaftaran Seminar (BARU)
        $seminars = \App\Models\PendaftaranSeminar::with('seminar')
            ->where('user_id', $id)
            ->where('user_type', $role)
            ->get();

        // 6. Ubah status role menjadi Bahasa Indonesia
        $statusLabel = 'Umum';
        if ($role === 'student') $statusLabel = 'Mahasiswa';
        if ($role === 'lecturer') $statusLabel = 'Dosen';

        // 7. Susun data profil
        $profile = [
            ['icon' => 'user', 'label' => 'Nama', 'value' => $user->nama ?? $user->name ?? '-'],
            ['icon' => 'id-card', 'label' => $role === 'lecturer' ? 'NIDN' : ($role === 'student' ? 'NPM' : 'ID'), 'value' => $user->npm ?? $user->nidn ?? '-'],
            ['icon' => 'mail', 'label' => 'Email', 'value' => $user->email ?? '-'],
            ['icon' => 'graduation-cap', 'label' => 'Prodi', 'value' => $user->prodi ?? '-'],
            ['icon' => 'phone', 'label' => 'No. HP', 'value' => $user->no_hp ?? '-'],
            ['icon' => 'user-round-check', 'label' => 'Status', 'value' => $statusLabel],
        ];

        // Kirim semua data termasuk $seminars ke view
        return view('pages.profile', compact('profile', 'pembayarans', 'seminars', 'user', 'filename'));
    }

    public function showForgotPasswordForm() {
        return view('pages.forgot-password', ['title' => 'Lupa Password']);
    }

    public function checkEmail(Request $request) {
        $request->validate(['email' => 'required|email']);
        $user = UserUmum::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        return redirect()->route('password.reset.form', ['email' => $user->email]);
    }

    public function showResetForm($email) {
        return view('pages.reset-password', ['email' => $email]);
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ]);

        UserUmum::where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);

        return redirect()->route('login.public')->with('success', 'Password berhasil diubah!');
    }

    public function logout()
    {
        session()->forget('auth_user');

        return redirect()->route('home');
    }

    private function checkPassword(string $input, string $stored): bool
    {
        if ($input === $stored) {
            return true;
        }

        if ($this->isBcryptHash($stored)) {
            return Hash::check($input, $stored);
        }

        return false;
    }

    private function isBcryptHash(string $value): bool
    {
        return preg_match('/^\$2[aby]\$\d{2}\$[\.\/A-Za-z0-9]{53}$/', $value) === 1;
    }
}