@extends('templates.main')
@section('title', 'Profile')

@section('content')
<section class="profile-page">
    <div class="profile-card">
        <div class="avatar-box">
           <img src="{{ asset('images/pasfoto/' . $filename) }}" alt="{{ $user->nama ?? 'User' }}" >
        </div>

        <div class="profile-info-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; width: 100%;">
            @foreach(collect($profile)->chunk(3) as $column)
                <div class="info-column" style="display: flex; flex-direction: column; gap: 15px;">
                    @foreach($column as $item)
                        <div class="profile-row">
                            <i data-lucide="{{ $item['icon'] }}"></i>
                            <b>{{ $item['label'] }}</b>
                            <span>:</span>
                            <p>{{ $item['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <div class="registered-card">
        <div class="section-title">
            <div><i data-lucide="menu"></i></div>
            <span><h2>Daftar</h2><p>Data Seminar & Sertifikasi</p></span>
        </div>

        <div class="tabs">
            <button class="active" onclick="switchProfileTab('seminar')">Data Seminar</button>
            <button onclick="switchProfileTab('sertifikasi')">Data Sertifikasi</button>
        </div>

        <div class="table-control">
            <label>Show <select><option>10</option></select> entries</label>
            <div class="search-box"><i data-lucide="search"></i><input placeholder="Search data..."></div>
        </div>

        {{-- PANEL 1: SEMINAR (Biarkan apa adanya) --}}
        <div id="profile-seminar-panel" class="responsive-table">
            <table>
                <thead>
                    <tr><th>No</th><th>Nama Seminar</th><th>Tanggal</th><th>Status</th><th>Sertifikat</th><th>Catatan</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <tr><td colspan="7" style="text-align: center;">Belum ada data.</td></tr>
                </tbody>
            </table>
        </div>

        {{-- PANEL 2: SERTIFIKASI (Tabel yang sudah terhubung ke data) --}}
        <div id="profile-sertifikasi-panel" class="responsive-table hidden">
            <table>
                <thead>
                    <tr><th>No</th><th>Nama Sertifikasi</th><th>Status</th><th>Catatan</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($pembayarans as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><b>{{ $p->sertifikasi->nama ?? '-' }}</b></td>
                        <td>
                            @if($p->status == 'lunas') <span class="badge bg-success">Lunas</span>
                            @elseif($p->status == 'ditolak') <span class="badge bg-danger">Ditolak</span>
                            @else <span class="badge bg-warning text-dark">Menunggu</span>
                            @endif
                        </td>
                        <td>{{ $p->catatan_admin ?? '-' }}</td>
                        <td>
                            @if($p->status == 'menunggu')
                                <form action="{{ route('pembayaran.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-sm btn-danger">Batalkan</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align: center;">Belum ada pendaftaran sertifikasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection