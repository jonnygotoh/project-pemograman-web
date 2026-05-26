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
                ->withInput();
        }

        session([
            'auth_user' => [
                'id' => $user->id,
                'name' => $user->nama ?? $user->name,
                'email' => $user->email,
                'role' => $request->type,
            ]
        ]);

        return redirect()->route('profile');
    }

    public function profile()
    {
        if (!session()->has('auth_user')) {
            return redirect()->route('login.choose');
        }

        $authUser = session('auth_user');

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
                'value' => ucfirst($authUser['role'])
            ],
        ];

        return view('pages.profile', [
            'profile' => $profile,
            'registered' => [],
        ]);
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