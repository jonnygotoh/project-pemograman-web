<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\Sertifikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\CalendarHelper;

class MainController extends Controller
{
    use CalendarHelper; 

    public function home(Request $request)
    {
        $month = $request->month ?? 6;
        $year = $request->year ?? 2026;
        $data = $this->landingData($month, $year);

        return view('pages.home', $data);
    }

   public function calendar(Request $request, $type)
    {
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        $calendarDays = $this->generateCalendar($month, $year, $type);

        return view('pages.partials.calendar', [
            'type' => $type,
            'month' => $month,
            'year' => $year,
            'calendarDays' => $calendarDays
        ]);
    }

    private function landingData($month, $year)
    {
        return [
            'month' => $month,
            'year' => $year,
            'seminarRows' => $this->seminarRows(),
            'certificationRows' => $this->certificationRows(),
            'seminarCalendar' => $this->generateCalendar($month, $year, 'seminar'),
            'certificationCalendar' => $this->generateCalendar($month, $year, 'sertifikasi'),
        ];
    }

    private function seminarRows()
    {
        return Seminar::withCount('pendaftar')->get()->map(function ($seminar, $index) {
            return [
                'id' => $seminar->id,
                'no' => $index + 1,
                'nama' => $seminar->nama,
                'periode' => $seminar->periode,
                'tanggal' => $seminar->tanggal ? Carbon::parse($seminar->tanggal)->format('d M Y') : '-',
                'waktu' => $seminar->waktu,
                'jumlah_pendaftar' => $seminar->pendaftar_count 
            ];
        });
    }

    private function certificationRows()
    {
        return Sertifikasi::withCount('pendaftarSertifikasi')->get()->map(function ($sertif, $index) {
            return [
                'id' => $sertif->id,
                'no' => $index + 1,
                'nama' => $sertif->nama,
                'batch' => $sertif->batch ?? '-',
                'periode' => $sertif->periode,
                'waktu' => $sertif->waktu ? Carbon::parse($sertif->waktu)->format('d M Y') : '-',
                'biaya' => "Mhs: Rp" . number_format($sertif->biaya_mahasiswa, 0, ',', '.') . 
                           " | Dosen: Rp" . number_format($sertif->biaya_dosen, 0, ',', '.') . 
                           " | Umum: Rp" . number_format($sertif->biaya_umum, 0, ',', '.'),
                'jumlah_pendaftar' => $sertif->pendaftar_sertifikasi_count 
            ];
        });
    }

    public function showSeminar($id)
    {
        $seminar = Seminar::findOrFail($id);
        $event = [
            'id'          => $seminar->id,
            'title'       => $seminar->nama,
            'description' => $seminar->deskripsi ?? '-',
            'date'        => $seminar->tanggal,
            'time'        => $seminar->waktu,
            'place'       => $seminar->tempat ?? '-',
            'mode'        => $seminar->mode ?? 'offline',
            'poster'      => $seminar->poster ?? null,
            'category'    => 'seminar' // Penanda agar blade tahu ini seminar
        ];
        return view('pages.detail', compact('event'));
    }

    public function showSertifikasi($id)
    {
        $sertif = Sertifikasi::findOrFail($id);
        $event = [
            'id'          => $sertif->id,
            'title'       => $sertif->nama,
            'description' => $sertif->deskripsi ?? '-',
            'date'        => $sertif->waktu,
            'time'        => $sertif->jam ?? '-',
            'place'       => $sertif->tempat ?? '-',
            'mode'        => $sertif->mode ?? 'offline',
            'poster'      => $sertif->poster ?? null,
            'category'    => 'sertifikasi' // Penanda agar blade tahu ini sertifikasi
        ];
        return view('pages.detail', compact('event'));
    }
    
    public function showUploadPage($sertifikasi_id)
        {
    // Pastikan sertifikasi ada di database sebelum menampilkan form
    $sertifikasi = \App\Models\Sertifikasi::findOrFail($sertifikasi_id);
    
    return view('pages.upload-payment', compact('sertifikasi_id'));
    }   

    public function verifikasiTokenSeminar(Request $request) 
    {
        $request->validate([
            'token' => 'required', 
            'pendaftaran_id' => 'required'
        ]);
        
        $pendaftar = \App\Models\PendaftaranSeminar::with('seminar')->find($request->pendaftaran_id);

        if (!$pendaftar) {
            return back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        if (!$pendaftar->seminar) {
            return back()->with('error', 'Data seminar tidak ditemukan.');
        }

        // 1. Validasi Token
        if (trim($request->token) !== trim($pendaftar->seminar->token_event)) {
            return back()->with('error', 'Token salah! Silakan periksa kembali token event Anda.');
        }

        // 2. WAJIB: Cek status, hanya boleh diproses jika statusnya 'ready_to_redeem'
        if ($pendaftar->status_sertifikat !== 'ready_to_redeem') {
            return back()->with('error', 'Sertifikat belum tersedia atau sudah diklaim.');
        }

        // 3. Update status menjadi 'verified' agar sertifikat bisa diakses
        $pendaftar->update(['status_sertifikat' => 'verified']);
        
        return back()->with('success', 'Berhasil! Sertifikat Anda sudah terverifikasi.');
    }

    /**
     * Show sertifikat preview untuk user
     */
    
    public function showSertifikatPreview($pendaftaran_id)
    {
        if (!session()->has('auth_user')) {
            return redirect()->route('login.choose')->with('error', 'Silakan login terlebih dahulu.');
        }

        $authUser = session('auth_user');
        $pendaftar = \App\Models\PendaftaranSeminar::findOrFail($pendaftaran_id);

        if ($pendaftar->user_id != $authUser['id'] || $pendaftar->user_type != $authUser['role']) {
            return back()->with('error', 'Anda tidak memiliki akses ke sertifikat ini.');
        }

        // WAJIB: Jika status masih 'ready_to_redeem', jangan izinkan akses
        if ($pendaftar->status_sertifikat === 'ready_to_redeem') {
            return back()->with('error', 'Silakan masukkan Token Event terlebih dahulu di dashboard untuk melihat sertifikat.');
        }

        // Cek jika status bukan verified
        if ($pendaftar->status_sertifikat !== 'verified') {
            return back()->with('error', 'Sertifikat belum tersedia untuk ditampilkan.');
        }

        if (!$pendaftar->sertif_no) {
            return back()->with('error', 'Data sertifikat belum lengkap.');
        }

            return view('pages.sertifpreview', [
            'no_sertifikat' => $pendaftar->sertif_no,
            'nama' => $pendaftar->sertif_nama ?? $authUser['name'],
            'npm' => $pendaftar->sertif_npm ?? $authUser['id'],
            'peran' => $pendaftar->sertif_peran ?? 'PESERTA',
            'kegiatan' => $pendaftar->sertif_kegiatan ?? $pendaftar->seminar->nama,
            'tanggal_terbit' => $pendaftar->sertif_tanggal ?? date('d F Y'),
        ]);
    }
    
}
