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

        {{-- PANEL 1: SEMINAR --}}
        <div id="profile-seminar-panel" class="responsive-table">
            <table>
                <thead>
                    <tr><th>No</th><th>Nama Seminar</th><th>Tanggal</th><th>Waktu</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($seminars as $i => $s)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <a href="{{ route('seminar.show', $s->seminar->id ?? 0) }}" style="text-decoration:none; color:inherit;">
                                <b>{{ $s->seminar->nama ?? 'N/A' }}</b>
                            </a>
                        </td>
                        <td>{{ $s->seminar->tanggal ?? '-' }}</td>
                        <td>{{ $s->seminar->waktu ?? '-' }}</td>
                        <td>
                            @if($s->status_sertifikat == 'verified')
                                <span class="badge bg-success">Sertifikat Siap</span>
                            @else
                                <span class="badge bg-info">Terdaftar</span>
                            @endif
                        </td>
                        <td>
                            @if($s->status_sertifikat == 'verified')
                                <a href="{{ asset('storage/' . $s->sertifikat_path) }}" target="_blank" class="btn-sm btn-primary">Lihat Sertifikat</a>
                            @else
                                <button type="button" onclick="openTokenModal({{ $s->id }})" class="btn-sm btn-info">Isi Token</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align: center;">Belum ada pendaftaran seminar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PANEL 2: SERTIFIKASI --}}
        <div id="profile-sertifikasi-panel" class="responsive-table hidden">
            <table>
                <thead>
                    <tr><th>No</th><th>Nama Sertifikasi</th><th>Skor</th><th>Status</th><th>Catatan</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($pembayarans as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <a href="{{ route('sertifikasi.show', $p->sertifikasi->id ?? 0) }}" style="text-decoration:none; color:inherit;">
                                <b>{{ $p->sertifikasi->nama ?? '-' }}</b>
                            </a>
                        </td>
                        <td>{{ $p->skor ?? '-' }}</td>
                        <td>
                            @php $skor = $p->skor; @endphp
                            @if(is_null($skor))
                                <span class="badge bg-warning text-dark">Menunggu Skor</span>
                            @elseif($skor < 70)
                                <span class="badge bg-danger">Tidak Lulus</span>
                            @else
                                <span class="badge bg-success">Lulus</span>
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
                    <tr><td colspan="6" style="text-align: center;">Belum ada pendaftaran sertifikasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

<div id="tokenModal" class="modal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div class="modal-content" style="background:white; width:300px; margin:15% auto; padding:20px; border-radius:8px;">
        <form action="{{ route('verifikasi.token.seminar') }}" method="POST">
            @csrf
            <input type="hidden" name="pendaftaran_id" id="modal_seminar_id">
            
            <h5>Masukkan Token</h5>
            <input type="text" name="token" class="form-control" placeholder="Masukkan token dari admin" required>
            
            <div style="margin-top:15px; text-align:right;">
                <button type="button" onclick="document.getElementById('tokenModal').style.display='none'" class="btn-sm btn-secondary">Batal</button>
                <button type="submit" class="btn-sm btn-primary">Verifikasi</button>
            </div>
        </form>
    </div>
</div>

@endsection