@php
$pageTitle = $pageTitle ?? 'Data';
$type = $type ?? 'items';
$columns = $columns ?? [];
$rows = $rows ?? [];
@endphp

<div class="table-card">
    <div class="table-title">
        <div>
            <h2>{{ $pageTitle }} List</h2>
            <p>All active {{ $type }} data</p>
        </div>
        <div class="search-box">
            <i data-lucide="search"></i>
            <input placeholder="Search {{ $type }}...">
        </div>
    </div>

    <div class="responsive-table">
        <table>
            <thead>
                <tr>
                    @foreach($columns as $col)
                        <th>{{ $col }}</th>
                    @endforeach
                    @if(request()->is('admin*')) <th>Actions</th> @endif
                </tr>
            </thead>

            <tbody>
                @foreach($rows as $row)
                    <tr>
                        @foreach($columns as $col)
                            @php
                                // Normalisasi kolom: "Nama Sertifikasi" -> "nama_sertifikasi"
                                // Tapi kita buat mapping agar otomatis mengenali key controller
                                $field = str_replace(' ', '_', strtolower($col));
                                
                                // Mapping Manual agar singkron
                                if($field === 'nama_sertifikasi') $field = 'nama';
                                if($field === 'periode_pendaftaran') $field = 'periode';
                                if($field === 'tanggal_pelatihan' || $field === 'tanggal_ujian') $field = 'waktu';
                                if($field === 'biaya_pendaftaran') $field = 'biaya';
                                if($field === 'jumlah_pendaftar') $field = 'pendaftar';
                            @endphp
                            
                            <td>{{ $row[$field] ?? '-' }}</td>
                        @endforeach

                        @if(request()->is('admin*'))
                            <td>
                                <a href="{{ route('admin.'.$type.'.edit', $row['id']) }}">Edit</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>