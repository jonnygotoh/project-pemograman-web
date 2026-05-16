<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/mahasiswa', [MahasiswaController::class, 'mahasiswa'])
    ->name('listmahasiswa');

// Route::get('/dosen', [DosenController::class, 'dosen'])
//     ->name('listdosen');

// Route::get('/admin', [AdminController::class, 'admin'])
//     ->name('listadmin');

// Route::get('/umum', [UmumController::class, 'umum'])
//     ->name('listumum');

// Route::get('/sertifikasi', [MahasiswaController::class, 'sertifikasi'])
//     ->name('listsertifikasi');

// Route::get('/seminar', [MahasiswaController::class, 'seminar'])
//     ->name('listseminar');

//new//
//<?php

//use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home', landingData());
})->name('home');

Route::get('/login', fn () => view('auth.choose'))->name('login.choose');

Route::get('/login/mahasiswa', fn () => view('auth.login', [
    'title' => 'Masuk Mahasiswa',
    'identityPlaceholder' => 'NPM',
    'type' => 'student',
    'note' => 'Silahkan login menggunakan akun portal mahasiswa',
]))->name('login.student');

Route::get('/login/dosen', fn () => view('auth.login', [
    'title' => 'Masuk Dosen UIB',
    'identityPlaceholder' => 'NIDN / Email',
    'type' => 'lecturer',
    'note' => 'Silahkan login menggunakan akun portal dosen',
]))->name('login.lecturer');

Route::get('/login/umum', fn () => view('auth.login', [
    'title' => 'Masuk Umum',
    'identityPlaceholder' => 'Email',
    'type' => 'public',
]))->name('login.public');

Route::post('/login/process', fn () => back())->name('login.process');
Route::get('/logout', fn () => redirect('/'))->name('logout');

Route::get('/event/detail', function () {
    return view('pages.detail', [
        'event' => [
            'type' => 'seminar',
            'title' => 'Series 11 – Latihan Rutin – UKM Taekwondo',
            'poster' => asset('images/poster-placeholder.png'),
            'description' => 'Universitas Internasional Batam memiliki Unit Kegiatan Mahasiswa Taekwondo yang telah berdiri lama dan aktif mengembangkan minat serta bakat mahasiswa di bidang olahraga.',
            'mode' => 'offline',
            'date' => 'Minggu, 17 Mei 2026',
            'time' => '13.00 - 15.30 WIB',
            'place' => 'Sport Hall, UIB',
        ]
    ]);
})->name('event.detail');

Route::get('/profile', function () {
    return view('pages.profile', [
        'profile' => [
            ['icon'=>'user','label'=>'Nama','value'=>'Your Full Name'],
            ['icon'=>'mail','label'=>'Email','value'=>'yourname@gmail.com'],
            ['icon'=>'id-card','label'=>'NPM','value'=>'2532046'],
            ['icon'=>'phone','label'=>'No. HP','value'=>'081234567890'],
            ['icon'=>'graduation-cap','label'=>'Prodi','value'=>'Teknologi Informasi'],
            ['icon'=>'user-round','label'=>'Status','value'=>'Mahasiswa'],
        ],
        'registered' => [
            ['name'=>'“Smart with AI Tools, Strong with Soft Skills”','certificate'=>'<a class="btn-small" href="#">Sertifikat</a>','action'=>'-'],
            ['name'=>'Ahlan Wa Sahlan “Merajut Silaturahmi, Menebar Kebaikan”','certificate'=>'<span class="login-note" style="width:auto;padding:8px 12px">Tidak Ada</span>','action'=>'-'],
            ['name'=>'The Fragile Giant : Why Businesses Must Trade Efficiency for Resilience','certificate'=>'-','action'=>'<button class="btn-small" onclick="openAttendanceToken()">Isi Token</button>'],
        ]
    ]);
})->name('profile');

Route::view('/upload-payment', 'pages.upload-payment')->name('upload.payment');

function landingData() {
    $seminarRows = [
        ['<b>ELE Webinar: The Professional Translator’s Launchpad Series 2</b><br><small>Free</small>', '07 Mei 2026 -<br>12 Mei 2026', '12 Mei 2026', '18:00:00 – 20:00:00', 'Online', '<span class="badge-free">Free</span>', '10', '<a class="btn-small" href="'.route('event.detail').'">Daftar Seminar</a>'],
        ['<b>LIVE DEMO: Essentials of BIM Design with Archicad</b><br><small>Free</small>', '06 Mei 2026 -<br>18 Mei 2026', '18 Mei 2026', '18:30:00 – 20:00:00', 'Auditorium UIB', '<span class="badge-free">Free</span>', '13', '<a class="btn-small" href="'.route('event.detail').'">Daftar Seminar</a>'],
    ];

    $certificationRows = [
        ['<b>Sertifikasi Calon Mediator</b><br><span class="tag">Pusat Sertifikasi</span> <span class="tag green">Gelombang 1</span>', '05 Mei 2026 -<br>26 Mei 2026', '30 Mei 2026 - 06 Juni 2026', '07 Juni 2026', 'Mahasiswa : Rp.750.000,00<br>Umum : Rp.1.350.000,00<br>Dosen : Rp.750.000,00', '30', '<a class="btn-small" href="'.route('event.detail').'">Daftar Sertifikasi</a>'],
        ['<b>Official TOEIC Test</b><br><span class="tag">UCLC</span> <span class="tag green">Periode 23 Mei 2026</span>', '07 Mei 2026 -<br>12 Mei 2026', '23 Mei 2026', '23 Mei 2026', 'Mahasiswa : Rp.500.000,00<br>Umum : Rp.675.000,00<br>Dosen : Rp.500.000,00', '24', '<a class="btn-small" href="'.route('event.detail').'">Daftar Sertifikasi</a>'],
    ];

    return [
        'seminarRows' => $seminarRows,
        'certificationRows' => $certificationRows,
        'seminarCalendar' => demoCalendarDays('seminar'),
        'certificationCalendar' => demoCalendarDays('certification'),
        'news' => [
            ['image'=>asset('images/news-placeholder.png'), 'date'=>'16 Mei 2026', 'title'=>'Informasi Pendaftaran Seminar Terbaru', 'summary'=>'Pendaftaran seminar dan webinar terbaru telah dibuka untuk mahasiswa, dosen, dan umum.'],
            ['image'=>asset('images/news-placeholder.png'), 'date'=>'15 Mei 2026', 'title'=>'Jadwal Sertifikasi Bulan Ini', 'summary'=>'Lihat jadwal sertifikasi terbaru beserta periode pelatihan dan ujian.'],
            ['image'=>asset('images/news-placeholder.png'), 'date'=>'14 Mei 2026', 'title'=>'Panduan Upload Bukti Pembayaran', 'summary'=>'Ikuti panduan upload bukti pembayaran agar proses verifikasi lebih cepat.'],
        ]
    ];
}

function demoCalendarDays($type) {
    $days = [];

    for ($i = 1; $i <= 35; $i++) {
        $hasEvent = in_array($i, $type === 'seminar' ? [10, 11, 12, 17, 18, 19, 22] : [7, 12, 23, 26, 30]);

        $days[] = [
            'date' => $i,
            'events' => $hasEvent ? [
                [
                    'title' => $type === 'seminar'
                        ? ($i == 17 ? 'Series 11 - Latihan Rutin - UKM Taekwondo' : 'Webinar / Seminar Event')
                        : ($i == 23 ? 'Official TOEIC Test' : 'Sertifikasi Event'),
                    'url' => route('event.detail')
                ]
            ] : []
        ];
    }

    return $days;
}
