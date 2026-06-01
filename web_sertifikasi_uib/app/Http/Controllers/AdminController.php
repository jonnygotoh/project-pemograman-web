<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\Sertifikasi;
use App\Models\PembayaranSertifikasi;
use App\Models\SertifikasiMahasiswa;
use App\Models\SertifikasiDosen;
use App\Models\SertifikasiUserUmum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\CalendarHelper;

class AdminController extends Controller
{
    use CalendarHelper; 

    public function dashboard(Request $request)
    {
        $month = $request->month ?? 6;
        $year = $request->year ?? 2026;

        $pembayaranMenunggu = PembayaranSertifikasi::where('status', 'menunggu')->get();

        return view('pages.dashboardAdmin', [
            'month' => $month,
            'year' => $year,
            // Menggunakan helper mapping agar format data seragam dengan tabel di Home
            'seminarRows' => $this->getSeminarRows(),
            'certificationRows' => $this->getCertificationRows(),
            'seminarCalendar' => $this->generateCalendar($month, $year, 'seminar'),
            'certificationCalendar' => $this->generateCalendar($month, $year, 'sertifikasi'),

            'pembayaranMenunggu' => $pembayaranMenunggu,
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

    public function seminarStore(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'periode' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required',
        ]);

        $data['jumlah_pendaftar'] = 0; 
        // Hapus validasi dan logika tipe/biaya
        Seminar::create($data);

        return redirect()->route('admin.dashboard')->with('success', 'Data Seminar berhasil ditambahkan!');
    }

    public function seminarUpdate(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);
        // Cukup update $request->all() atau spesifik field
        $seminar->update($request->only(['nama', 'periode', 'tanggal', 'waktu']));

        return redirect()->route('admin.dashboard')->with('success', 'Data Seminar berhasil diubah!');
    }

    public function seminarDelete($id)
    {
        Seminar::find($id)->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Data Seminar berhasil dihapus!');
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
}