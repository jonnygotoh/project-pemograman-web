@php
$pageTitle = $pageTitle ?? 'Data';
$type = $type ?? 'items'; // 'seminar' atau 'sertifikasi'
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
                    @if(request()->is('admin*')) <th>Actions</th> @endif
                </tr>
            </thead>

            <tbody>
                @foreach($rows as $row)
                    @php
                        $id = is_array($row) ? $row['id'] : $row->id;
                        // Menentukan route berdasarkan $type
                        $routeName = ($type == 'seminar') ? 'seminar.show' : 'sertifikasi.show';
                        $detailUrl = route($routeName, ['id' => $id]);
                    @endphp

                    <tr onclick="window.location='{{ $detailUrl }}';" style="cursor: pointer;">
                        @foreach($columns as $col)
                            @php
                                $field = str_replace(' ', '_', strtolower($col));
                                if($field === 'nama_sertifikasi') $field = 'nama';
                                if($field === 'periode_pendaftaran') $field = 'periode';
                                if($field === 'tanggal_pelatihan' || $field === 'tanggal_ujian') $field = 'waktu';
                                if($field === 'biaya_pendaftaran') $field = 'biaya';
                            @endphp
                            
                            <td>
                                {{ is_array($row) ? ($row[$field] ?? '-') : ($row->{$field} ?? '-') }}
                            </td>
                        @endforeach

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
</div>