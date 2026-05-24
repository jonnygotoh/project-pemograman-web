<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\UserUmum;
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
        if (!array_key_exists($type, $this->types)) {
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
        'type' => 'required'
    ]);

    $type = $request->type;
    $config = $this->types[$type];
    $model = $config['model'];

    $query = $model::query();

    foreach ($config['identity'] as $i => $field) {
        if ($i === 0) {
            $query->where($field, $request->identity);
        } else {
            $query->orWhere($field, $request->identity);
        }
    }

    $user = $query->first();

    if (!$user || !$this->checkPassword($request->password, $user->password)) {
        return back()->withErrors([
            'identity' => 'Login gagal'
        ]);
    }

    session(['auth_user' => [
        'id' => $user->id,
        'name' => $user->nama ?? $user->name,
        'email' => $user->email,
        'role' => $type,
    ]]);

    return redirect()->route('profile');
}
public function profile()
{
    if (!session()->has('auth_user')) {
        return redirect()->route('login.choose');
    }

    $authUser = session('auth_user');

    // dummy data sementara biar tidak error
    $profile = [
        [
            'icon' => 'user',
            'label' => 'Nama',
            'value' => $authUser['name']
        ],
        [
            'icon' => 'mail',
            'label' => 'Email',
            'value' => $authUser['email']
        ],
        [
            'icon' => 'user-check',
            'label' => 'Role',
            'value' => $authUser['role']
        ],
    ];

    $registered = []; // sementara kosong dulu

    return view('pages.profile', compact('profile', 'registered'));
}

    public function logout()
    {
        session()->forget('auth_user');

        return redirect()->route('home');
    }

    private function checkPassword(string $input, string $stored): bool
    {
        return $input === $stored || Hash::check($input, $stored);
    }

    private function buildProfile(array $authUser): array
    {
        $data = $authUser;

        return match ($authUser['role']) {
            'student' => [
                ['icon' => 'hash', 'label' => 'NPM', 'value' => $data['npm'] ?? '-'],
                ['icon' => 'user', 'label' => 'Nama', 'value' => $data['nama'] ?? '-'],
                ['icon' => 'mail', 'label' => 'Email', 'value' => $data['email'] ?? '-'],
                ['icon' => 'smartphone', 'label' => 'No HP', 'value' => $data['no_hp'] ?? '-'],
                ['icon' => 'book-open', 'label' => 'Prodi', 'value' => $data['prodi'] ?? '-'],
            ],
            'lecturer' => [
                ['icon' => 'hash', 'label' => 'NIDN', 'value' => $data['nidn'] ?? '-'],
                ['icon' => 'user', 'label' => 'Nama', 'value' => $data['nama'] ?? '-'],
                ['icon' => 'mail', 'label' => 'Email', 'value' => $data['email'] ?? '-'],
                ['icon' => 'smartphone', 'label' => 'No HP', 'value' => $data['no_hp'] ?? '-'],
                ['icon' => 'layers', 'label' => 'Jurusan', 'value' => $data['jurusan'] ?? '-'],
            ],
            default => [
                ['icon' => 'user', 'label' => 'Nama', 'value' => $data['nama'] ?? '-'],
                ['icon' => 'mail', 'label' => 'Email', 'value' => $data['email'] ?? '-'],
                ['icon' => 'smartphone', 'label' => 'No HP', 'value' => $data['no_hp'] ?? '-'],
                ['icon' => 'map-pin', 'label' => 'Alamat', 'value' => $data['alamat'] ?? '-'],
            ],
        };
    }
}
