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
                </tr>
            </thead>

            <tbody>
                @foreach($rows as $row)
                    <tr>
                        @foreach($row as $cell)
                            <td>{!! $cell !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>