<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\Sertifikasi;
use App\Models\PembayaranSertifikasi;
use App\Models\SertifikasiMahasiswa;
use App\Models\SertifikasiDosen;
use App\Models\SertifikasiUserUmum;
use App\Models\PendaftaranSeminar;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\UserUmum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Traits\CalendarHelper;

class AdminController extends Controller
{
    use CalendarHelper; 

    public function dashboard(Request $request)
    {
        $month = $request->month ?? 6;
        $year = $request->year ?? 2026;

        $pembayaranMenunggu = PembayaranSertifikasi::where('status', 'menunggu')->get();
        
        // Add bukti_bayar URL to each payment
        $pembayaranMenunggu = $pembayaranMenunggu->map(function($item) {
            $item->bukti_bayar_url = route('bukti.view', ['filename' => $item->bukti_bayar]);
            return $item;
        });

        return view('pages.dashboardAdmin', [
            'month' => $month,
            'year' => $year,
            // Menggunakan helper mapping agar format data seragam dengan tabel di Home
            'seminarRows' => $this->getSeminarRows(),
            'certificationRows' => $this->getCertificationRows(),
            'seminarCalendar' => $this->generateCalendar($month, $year, 'seminar'),
            'certificationCalendar' => $this->generateCalendar($month, $year, 'sertifikasi'),

            'pembayaranMenunggu' => $pembayaranMenunggu,
            'seminarVerifikasi' => $this->getSeminarVerifikasi(),
        ]);
    }

    private function getSeminarRows() {
        return Seminar::withCount('pendaftar')->get()->map(function ($s, $index) {
            return (object) [
                'id' => $s->id,
                'no' => $index + 1,
                'nama' => $s->nama,
                'periode' => $s->periode,
                'tanggal' => $s->tanggal ? Carbon::parse($s->tanggal)->format('d M Y') : '-',
                'waktu' => $s->waktu,
                'jumlah_pendaftar' => $s->pendaftar_count
            ];
        });
    }

    private function getCertificationRows() {
        return Sertifikasi::withCount('pendaftarSertifikasi')->get()->map(function ($s, $index) {
            return (object) [
                'id' => $s->id,
                'no' => $index + 1,
                'nama' => $s->nama,
                'periode' => $s->periode,
                'waktu' => $s->waktu ? Carbon::parse($s->waktu)->format('d M Y') : '-',
                'biaya' => "Mhs: Rp" . number_format($s->biaya_mahasiswa, 0, ',', '.') . " | Dosen: Rp" . number_format($s->biaya_dosen, 0, ',', '.') . " | Umum: Rp" . number_format($s->biaya_umum, 0, ',', '.'),
                'jumlah_pendaftar' => $s->pendaftar_sertifikasi_count
            ];
        });
    }

// =====================
// SERTIFIKASI
// =====================

    public function seminarCreate() {
        return view('crud.seminar');
    }
    public function seminarEdit($id) {
        $item = Seminar::findOrFail($id);
        return view('crud.seminar', compact('item'));
    }

    public function seminarStore(Request $request) {
        $data = $request->validate([
            'nama' => 'required',
            'periode' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'token_event' => 'required|unique:seminar,token_event' // Input dari form
        ]);
        Seminar::create($data);
        return redirect()->route('admin.dashboard');
    }

    public function seminarUpdate(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);

        // Tambahkan 'token_event' di dalam array 'only'
        $seminar->update($request->only([
            'nama', 
            'periode', 
            'tanggal', 
            'waktu', 
            'token_event' // <--- INI KUNCI AGAR DATA TERSIMPAN
        ]));

        return redirect()->route('admin.dashboard')->with('success', 'Data Seminar berhasil diubah!');
    }

    public function seminarDelete($id)
    {
        Seminar::find($id)->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Data Seminar berhasil dihapus!');
    }

    public function generateCertificate(Request $request)
    {
    return view('admin.sertifikat-preview', [
        'no_sertifikat' => $request->no_sertifikat,
        'nama'          => $request->nama,
        'npm'           => $request->npm,
        'peran'         => $request->peran,
        'kegiatan'      => $request->kegiatan,
        'tanggal'       => $request->tanggal,
    ]);
    }
        
    public function updateSertifikatSeminar(Request $request, $id)
    {
        $request->validate([
            'sertifikat' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $pendaftar = \App\Models\PendaftaranSeminar::findOrFail($id);
        
        // Simpan file
        $path = $request->file('sertifikat')->store('sertifikat/seminar', 'public');
        
        // Update data: status jadi 'verified' agar sistem mengenali sertifikat sudah siap
        $pendaftar->update([
            'sertifikat_path' => $path,
            'status_sertifikat' => 'verified' 
        ]);

        return back()->with('success', 'Sertifikat berhasil diupload dan dipublikasikan ke peserta.');
    }

    // =====================
    // SERTIFIKASI
    // =====================

    public function sertifikasiCreate() {
        return view('crud.sertifikasi');
    }

    public function sertifikasiEdit($id) {
        $item = Sertifikasi::findOrFail($id);
        return view('crud.sertifikasi', compact('item'));
    }
    
    public function sertifikasiStore(Request $request)
    {

        $validated = $request->validate([
            'nama' => 'required',
            'batch' => 'nullable',
            'periode' => 'required',
            'waktu' => 'required|date',
            'biaya_mahasiswa' => 'required|numeric',
            'biaya_dosen' => 'required|numeric',
            'biaya_umum' => 'required|numeric',
        ]);

        $validated['jumlah_pendaftar'] = 0;

        Sertifikasi::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Data Sertifikasi berhasil ditambahkan!');
    }

    public function sertifikasiUpdate(Request $request, $id)
    {
        $sertif = Sertifikasi::findOrFail($id);
        $sertif->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Data Sertifikasi berhasil diubah!');
    }

    public function sertifikasiDelete($id)
    {
        Sertifikasi::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Data Sertifikasi berhasil dihapus!');
    }

    // --- Verifikasi Pembayaran Method ---
    public function verifikasiPembayaran(Request $request, $id)
    {
        // 1. Validasi input: status wajib, skor opsional (0-100), catatan opsional
        $request->validate([
            'status'        => 'required|in:lunas,ditolak',
            'skor'          => 'nullable|numeric|min:0|max:100', 
            'catatan_admin' => 'nullable|string'
        ]);

        $pembayaran = PembayaranSertifikasi::findOrFail($id);

        DB::transaction(function () use ($pembayaran, $request) {
            // 2. Update status, skor, dan catatan di tabel pembayaran_sertifikasi
            $pembayaran->update([
                'status'        => $request->status, 
                'skor'          => $request->skor,
                'catatan_admin' => $request->catatan_admin
            ]);

            // 3. Update status pembayaran di tabel relasi (Mahasiswa/Dosen/Umum)
            $statusToSet = $request->status; 

            switch ($pembayaran->user_type) {
                case 'student':
                    SertifikasiMahasiswa::where('npm', $pembayaran->user_id)
                        ->where('sertifikasi_id', $pembayaran->sertifikasi_id)
                        ->update(['status_pembayaran' => $statusToSet]);
                    break;
                case 'lecturer':
                    SertifikasiDosen::where('nidn', $pembayaran->user_id)
                        ->where('sertifikasi_id', $pembayaran->sertifikasi_id)
                        ->update(['status_pembayaran' => $statusToSet]);
                    break;
                case 'public':
                    SertifikasiUserUmum::where('user_umum_id', $pembayaran->user_id)
                        ->where('sertifikasi_id', $pembayaran->sertifikasi_id)
                        ->update(['status_pembayaran' => $statusToSet]);
                    break;
            }
        });

        return redirect()->route('admin.dashboard')->with('success', 'Status dan skor berhasil diperbarui!');
    }

    // =====================
    // VERIFIKASI SEMINAR
    // =====================

    /**
     * Get all pending seminar registrations that need certificate verification
     */
   /**
     * Get user data from the appropriate table
     */
    private function getUserData($user_id, $user_type)
    {
        $data = [
            'nama' => 'N/A',
            'npm' => 'N/A'
        ];

        try {
            if ($user_type === 'student') {
                // Coba cari berdasarkan NPM, jika gagal cari berdasarkan ID
                $mahasiswa = \App\Models\Mahasiswa::where('npm', $user_id)->first() ?? \App\Models\Mahasiswa::find($user_id);
                if ($mahasiswa) {
                    $data['nama'] = $mahasiswa->nama;
                    $data['npm'] = $mahasiswa->npm;
                }
            } elseif ($user_type === 'lecturer') {
                // Coba cari berdasarkan NIDN, jika gagal cari berdasarkan ID
                $dosen = \App\Models\Dosen::where('nidn', $user_id)->first() ?? \App\Models\Dosen::find($user_id);
                if ($dosen) {
                    $data['nama'] = $dosen->nama;
                    $data['npm'] = $dosen->nidn;
                }
            } elseif ($user_type === 'public') {
                $umum = \App\Models\UserUmum::find($user_id);
                if ($umum) {
                    $data['nama'] = $umum->nama;
                    $data['npm'] = $umum->email;
                }
            }
        } catch (\Exception $e) {
            // Log error jika perlu
            return $data;
        }

        return $data;
    }

    /**
     * Get all pending seminar registrations that need certificate verification
     */
    public function getSeminarVerifikasi()
    {
        return \App\Models\PendaftaranSeminar::with(['seminar'])
            ->where('status_sertifikat', '!=', 'verified')
            ->get()
            ->map(function ($item, $index) {
                $userData = $this->getUserData($item->user_id, $item->user_type);
                
                return (object) [
                    'pendaftaran_id' => $item->id,
                    'no' => $index + 1,
                    // Jika tetap N/A, ini akan memberi petunjuk di tabel (debug mode)
                    'nama' => ($userData['nama'] !== 'N/A') ? $userData['nama'] : '('.$item->user_type.') ID: '.$item->user_id,
                    'npm' => $userData['npm'],
                    'tanggal_ikut' => $item->seminar->tanggal ?? '-',
                    'user_id' => $item->user_id,
                    'user_type' => $item->user_type,
                    'seminar_id' => $item->seminar_id,
                    'status' => $item->status_sertifikat
                ];
            });
    }

    /**
     * Show sertifmaker form for editing seminar certificate
     */
    public function editSertifikatSeminarVerifikasi($pendaftaran_id)
    {
        $pendaftar = \App\Models\PendaftaranSeminar::with('seminar')
            ->findOrFail($pendaftaran_id);

        $userData = $this->getUserData($pendaftar->user_id, $pendaftar->user_type);

        // Get session data if exists
        $sessionData = session('sertif_data_' . $pendaftaran_id, []);

        return view('pages.sertifmaker-admin', [
            'pendaftaran_id' => $pendaftaran_id,
            'user_id' => $pendaftar->user_id,
            'user_type' => $pendaftar->user_type,
            'nama' => $userData['nama'],
            'npm' => $userData['npm'],
            'seminar_nama' => $pendaftar->seminar->nama,
            'tanggal_seminar' => $pendaftar->seminar->tanggal,
            'no_sertifikat' => $sessionData['no_sertifikat'] ?? '',
            'peran' => $sessionData['peran'] ?? 'PESERTA',
            'kegiatan' => $sessionData['kegiatan'] ?? $pendaftar->seminar->nama,
            // UBAH DARI date('d F Y') MENJADI date('d/m/Y')
            'tanggal_terbit' => $sessionData['tanggal_terbit'] ?? date('d/m/Y'),
        ]);
    }

    /**
     * Store sertifikat data to session and show preview
     */
    public function storeSertifikatSeminarVerifikasi(Request $request, $pendaftaran_id)
    {
        // Validasi ini sudah benar, tetap gunakan ini
        $request->validate([
            'no_sertifikat' => 'required|string',
            'peran' => 'required|string',
            'kegiatan' => 'required|string',
            'tanggal_terbit' => 'required|string',
        ]);

        $pendaftar = \App\Models\PendaftaranSeminar::with('seminar')
            ->findOrFail($pendaftaran_id);

        $userData = $this->getUserData($pendaftar->user_id, $pendaftar->user_type);

        // Save to session
        session([
            'sertif_data_' . $pendaftaran_id => [
                'pendaftaran_id' => $pendaftaran_id,
                'no_sertifikat' => $request->no_sertifikat,
                'nama' => $userData['nama'],
                'npm' => $userData['npm'],
                'peran' => $request->peran,
                'kegiatan' => $request->kegiatan,
                'tanggal_terbit' => $request->tanggal_terbit, // Ini akan menyimpan '13/06/2026'
                'user_id' => $pendaftar->user_id,
                'user_type' => $pendaftar->user_type,
                'seminar_id' => $pendaftar->seminar_id,
            ]
        ]);

        return redirect()->route('admin.sertif.preview', ['pendaftaran_id' => $pendaftaran_id]);
    }

        public function previewSertifikatSeminarVerifikasi($pendaftaran_id)
    {
        $sessionData = session('sertif_data_' . $pendaftaran_id);

        if (!$sessionData) {
            return redirect()->route('admin.dashboard')->with('error', 'Data sertifikat tidak ditemukan.');
        }

        return view('pages.sertifpreview-admin', [
            'no_sertifikat' => $sessionData['no_sertifikat'],
            'nama' => $sessionData['nama'],
            'npm' => $sessionData['npm'],
            'peran' => $sessionData['peran'],
            'kegiatan' => $sessionData['kegiatan'],
            'tanggal_terbit' => $sessionData['tanggal_terbit'],
            'pendaftaran_id' => $pendaftaran_id,
        ]);
    }

    /**
     * Show certificate preview
     */
    public function confirmSertifikatSeminarVerifikasi(Request $request, $pendaftaran_id)
    {
        $sessionData = session('sertif_data_' . $pendaftaran_id);

        if (!$sessionData) {
            return redirect()->route('admin.dashboard')->with('error', 'Data sertifikat tidak ditemukan.');
        }

        $pendaftar = \App\Models\PendaftaranSeminar::findOrFail($pendaftaran_id);

        // UBAH BARIS INI: dari 'verified' menjadi 'ready_to_redeem'
        $pendaftar->update([
            'status_sertifikat' => 'ready_to_redeem', 
            'sertif_no' => $sessionData['no_sertifikat'],
            'sertif_nama' => $sessionData['nama'],
            'sertif_npm' => $sessionData['npm'],
            'sertif_peran' => $sessionData['peran'],
            'sertif_kegiatan' => $sessionData['kegiatan'],
            'sertif_tanggal' => $sessionData['tanggal_terbit'],
        ]);

        session()->forget('sertif_data_' . $pendaftaran_id);

        return redirect()->route('admin.dashboard')->with('success', 'Sertifikat berhasil disiapkan. Peserta harus memasukkan token untuk mengaksesnya.');
    }
    
}


