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
                        <th data-sortable="true">
                            <span class="sort-label">{{ $col }}</span>
                            <span class="sort-icon">↕</span>
                        </th>
                    @endforeach

                    @if(!request()->is('admin*'))
                        <th>Aksi</th>
                    @endif

                    @if(request()->is('admin*'))
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>

            <tbody class="paginated-body">
                @foreach($rows as $row)
                    @php
                        $id = is_array($row) ? $row['id'] : $row->id;
                        $user = session('auth_user');
                        $routeName = ($type == 'seminar') ? 'seminar.show' : 'sertifikasi.show';
                        $detailUrl = route($routeName, ['id' => $id]);
                        
                        // Cek status pendaftaran
                        $terdaftar = $user ? ($type == 'sertifikasi' 
                            ? \App\Models\PembayaranSertifikasi::where('sertifikasi_id', $id)->where('user_id', $user['id'])->exists()
                            : \App\Models\PendaftaranSeminar::where('seminar_id', $id)->where('user_id', $user['id'])->exists())
                            : false;
                    @endphp

                    <tr onclick="window.location='{{ $detailUrl }}';" style="cursor:pointer;">
                        @foreach($columns as $col)
                            @php
                                $field = str_replace(' ', '_', strtolower($col));
                                if($field === 'nama_sertifikasi') $field = 'nama';
                                if($field === 'periode_pendaftaran') $field = 'periode';
                                if($field === 'tanggal_pelatihan' || $field === 'tanggal_ujian') $field = 'waktu';
                                if($field === 'biaya_pendaftaran') $field = 'biaya';
                            @endphp
                            <td>{{ is_array($row) ? ($row[$field] ?? '-') : ($row->{$field} ?? '-') }}</td>
                        @endforeach
                        
                        @if(!request()->is('admin*'))
                            <td onclick="event.stopPropagation();">
                                @if(!$user)
                                    <a href="{{ route('login.choose') }}" class="btn-primary">Login</a>
                                @elseif($terdaftar)
                                    <button class="btn-primary" disabled style="opacity:0.6; cursor:not-allowed;">Sudah Daftar</button>
                                @else
                                    @if($type == 'sertifikasi')
                                        <a href="javascript:void(0)" class="btn-primary" onclick="confirmDaftar('{{ route('upload.payment', ['sertifikasi_id' => $id]) }}', 'Sertifikasi')">Daftar Sertifikasi</a>
                                    @else
                                        <a href="javascript:void(0)" class="btn-primary" onclick="confirmDaftarSeminar('form-seminar-{{ $id }}')">Daftar Seminar</a>
                                        <form id="form-seminar-{{ $id }}" action="{{ route('pendaftaran.seminar.store') }}" method="POST" style="display:none;">
                                            @csrf
                                            <input type="hidden" name="seminar_id" value="{{ $id }}">
                                        </form>
                                    @endif
                                @endif
                            </td>
                        @endif

                        @if(request()->is('admin*'))
                            <td onclick="event.stopPropagation();">
                                <a href="{{ route('admin.'.$type.'.edit', $id) }}">Edit</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="table-pagination">
        <div class="entries-info">Showing 1 of 5 to 5 entries</div>
        <button class="page-btn prev-btn">Prev</button>
        <div class="page-numbers"></div>
        <button class="page-btn next-btn">Next</button>
    </div>
</div>