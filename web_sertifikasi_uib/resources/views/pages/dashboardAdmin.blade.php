@extends('templates.main')

@section('title', 'Admin Dashboard - UIB Event')

@php($isLanding = true)

@section('content')

<div class="admin-banner">
    <strong>Admin Panel</strong>
    <span>Sistem Manajemen Event Universitas Internasional Batam</span>
</div>

<section id="home" class="section hero-section loaded-active no-select admin-hero">
    <div class="hero-text js-reveal">
        <span class="delay-1 admin-label">ADMIN DASHBOARD</span>
        <h1 class="delay-2">Selamat Datang <br> Admin</h1>
        <h2 class="delay-3">{{ session('admin_name') }}</h2>
        <p class="delay-4">
            Kelola seminar dan sertifikasi Universitas Internasional Batam
            dengan tampilan modern, cepat, dan terstruktur.
        </p>
        <div class="admin-hero-actions delay-4">
            <a href="#sertifikasi" class="btn-primary">Kelola Sertifikasi</a>
            <a href="#seminar" class="btn-outline">Kelola Seminar</a>
        </div>
        <div class="dashboard-stats delay-4">
            <div class="status-card">
                <span>Seminar Aktif</span>
                <strong>{{ $seminarRows->count() }}</strong>
            </div>
            <div class="status-card">
                <span>Sertifikasi Aktif</span>
                <strong>{{ $certificationRows->count() }}</strong>
            </div>
            <div class="status-card">
                <span>Periode</span>
                <strong>{{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}</strong>
            </div>
        </div>
    </div>
    <div class="hero-image js-reveal-img">
        <img src="{{ asset('images/education.png') }}" alt="Education Illustration" class="delay-4">
    </div>
</section>

{{-- SECTION SERTIFIKASI --}}
<section id="sertifikasi" class="section data-section admin-section">
    <div class="section-heading js-reveal admin-heading">
        <span class="delay-1" id="left">Sertifikasi</span>
        <div class="admin-section-header">
            <div>
                <h2 class="delay-2" id="down">Daftar Sertifikasi</h2>
                <p class="admin-subtitle" id="down">Kelola jadwal dan data sertifikasi mahasiswa.</p>
            </div>
            <button onclick="window.location.href='{{ route('admin.sertifikasi.create') }}'" class="btn-primary">
                + Tambah Sertifikasi
            </button>
        </div>
        <div class="heading-line"></div>
    </div>

    <div class="view-toggle">
        <button class="active" onclick="switchView('sertifikasi','calendar')">Kalender</button>
        <button onclick="switchView('sertifikasi','table')">Tabel</button>
    </div>

    <div id="sertifikasi-calendar" class="view-panel">
        @include('pages.partials.calendar', [
            'type' => 'sertifikasi',
            'month' => $month,
            'year' => $year,
            'calendarDays' => $certificationCalendar
        ])
    </div>

    <div id="sertifikasi-table" class="view-panel hidden">
        @include('pages.partials.table', [
            'pageTitle' => 'Sertifikasi',
            'type' => 'sertifikasi',
            'columns' => ['No', 'Nama Sertifikasi', 'Periode Pendaftaran', 'Tanggal Pelatihan', 'Tanggal Ujian', 'Biaya Pendaftaran', 'Jumlah Pendaftar'],
            'rows' => $certificationRows
        ])
    </div>
</section>

{{-- SECTION SEMINAR --}}
<section id="seminar" class="section data-section admin-section">
    <div class="section-heading js-reveal admin-heading">
        <span class="delay-1" id="left">Seminar</span>
        <div class="admin-section-header">
            <div>
                <h2 class="delay-2">Daftar Seminar</h2>
                <p class="admin-subtitle">Atur event seminar dan aktivitas kampus.</p>
            </div>
            <button onclick="window.location.href='{{ route('admin.seminar.create') }}'" class="btn-primary">
                + Tambah Seminar
            </button>
        </div>
        <div class="heading-line"></div>
    </div>

    <div class="view-toggle">
        <button class="active" onclick="switchView('seminar','calendar')">Kalender</button>
        <button onclick="switchView('seminar','table')">Tabel</button>
    </div>

    <div id="seminar-calendar" class="view-panel">
        @include('pages.partials.calendar', [
            'type' => 'seminar',
            'month' => $month,
            'year' => $year,
            'calendarDays' => $seminarCalendar
        ])
    </div>

    <div id="seminar-table" class="view-panel hidden">
        @include('pages.partials.table', [
            'pageTitle' => 'Seminar',
            'type' => 'seminar',
            // Hapus 'Biaya' dari array columns
            'columns' => ['No', 'Nama', 'Periode', 'Tanggal', 'Waktu', 'Pendaftar'],
            'rows' => $seminarRows
        ])
    </div>
</section>

{{-- SECTION PEMBAYARAN --}}
<section id="pembayaran" class="section data-section admin-section">
    <div class="section-heading js-reveal admin-heading">
        <span class="delay-1" id="left">Pembayaran</span>
        <h2 class="delay-2">Verifikasi Pembayaran</h2>
        <div class="heading-line"></div>
    </div>
    <div class="view-panel">
        
        <div class="admin-table-container">

            <table class="table" id="pembayaranTable">
                <thead>
                    <tr>
                        <th class="sortable" data-column="no">No <span class="sort-icon">⇅</span></th>
                        <th class="sortable" data-column="user_id">User ID <span class="sort-icon">⇅</span></th>
                        <th class="sortable" data-column="tipe">Tipe <span class="sort-icon">⇅</span></th>
                        <th>Bukti Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayaranMenunggu as $index => $item)
                    <tr data-no="{{ $index + 1 }}" data-user-id="{{ $item->user_id }}" data-tipe="{{ $item->user_type }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->user_id }}</td>
                        <td>{{ ucfirst($item->user_type) }}</td>
                        <td>
                            <div class="thumbnail-wrapper">
                                @if($item->bukti_bayar_url)
                                <img 
                                    src="{{ $item->bukti_bayar_url }}" 
                                    alt="Bukti Bayar" 
                                    class="bukti-thumbnail"
                                    onclick="openImageModal(event)"
                                    style="cursor: pointer;"
                                    onerror="this.src='{{ asset('images/no-image.png') }}'; this.style.cursor='default';"
                                >
                                @else
                                <span class="text-muted">Tidak ada bukti</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <form action="{{ route('admin.verifikasi.pembayaran', $item->id) }}" method="POST" onsubmit="return confirm('Simpan data ini?')">
                                @csrf
                                <select name="status" class="form-input" style="display: block; margin-bottom: 5px;">
                                    <option value="lunas">Lunas</option>
                                    <option value="ditolak">Tolak</option>
                                </select>
                                <input type="number" name="skor" placeholder="Skor (0-100)" class="form-input" min="0" max="100" required style="display: block; margin-bottom: 5px; width: 130px;">
                                <input type="text" name="catatan_admin" value="Lunas" placeholder="Catatan" class="form-input" style="display: block; margin-bottom: 5px;">                               <button type="submit" class="btn-primary">Simpan</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align: center;">Tidak ada pembayaran yang perlu diverifikasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
    </div>

    <!-- Modal Preview Gambar -->
    <div id="imageModal" class="image-modal" style="display: none;" onclick="handleModalClick(event)">
        <div class="image-modal-wrapper">
            <div id="imageModalContent" class="image-modal-content">
                <button class="close-btn" onclick="closeImageModal()" title="Tutup">&times;</button>
                <div class="image-zoom-container">
                    <img id="modalImage" src="" alt="Preview" class="zoomable-image">
                </div>
                <div class="zoom-controls">
                    <button class="zoom-btn" onclick="zoomImage(-0.1)" title="Perkecil">−</button>
                    <span class="zoom-percentage" id="zoomPercentage">100%</span>
                    <button class="zoom-btn" onclick="zoomImage(0.1)" title="Perbesar">+</button>
                    <button class="zoom-btn" onclick="resetZoom()" title="Reset">Reset</button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SECTION VERIFIKASI SEMINAR --}}
<section id="seminar" class="section data-section admin-section">
    <div class="section-heading js-reveal admin-heading">
        <span class="delay-1" id="left">Seminar</span>
        <h2 class="delay-2">Verifikasi Seminar Sertifikat</h2>
        <div class="heading-line"></div>
    </div>
    <div class="view-panel">
        
        <div class="admin-table-container">

            <table class="table" id="SeminarVerifikasi">
                <thead>
                    <tr>
                        <th class="sortable" data-column="no">No <span class="sort-icon">⇅</span></th>
                        <th class="sortable" data-column="user_id">User ID <span class="sort-icon">⇅</span></th>
                        <th class="sortable" data-column="tipe">Tipe <span class="sort-icon">⇅</span></th>
                        <th class="sortable" data-column="tipe">Sertifikat <span class="sort-icon">⇅</span></th>
                    </tr>
                       
                </thead>
                </tbody>
            </table>
    </div>
    
    </div>
</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script>
    let currentZoom = 1;
    const minZoom = 0.6;
    const maxZoom = 1.5;
    let isPanning = false;
    let panStartX = 0;
    let panStartY = 0;
    let panX = 0;
    let panY = 0;

    function handleModalClick(event) {
        // Hanya close jika click di area gelap (bukan di modal content)
        if (event.target.id === 'imageModal') {
            closeImageModal();
        }
    }

    function openImageModal(event) {
        // Jangan buka modal jika gambar tidak bisa di-load
        if (event.currentTarget.naturalHeight === 0) {
            alert('Gambar tidak dapat ditampilkan');
            return;
        }
        
        const imageSrc = event.currentTarget.src;
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        
        if (!modal || !modalImage) {
            console.error('Modal elements not found');
            return;
        }
        
        modalImage.src = imageSrc;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Reset zoom setiap kali modal dibuka
        resetZoom();
        initZoomHandlers();
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        // Reset zoom values
        currentZoom = 1;
        panX = 0;
        panY = 0;
    }

    function zoomImage(factor) {
        const newZoom = currentZoom + factor;
        if (newZoom >= minZoom && newZoom <= maxZoom) {
            currentZoom = newZoom;
            updateModalZoom();
        }
    }

    function resetZoom() {
        currentZoom = 1;
        panX = 0;
        panY = 0;
        updateModalZoom();
    }

    function updateModalZoom() {
        const modalContent = document.getElementById('imageModalContent');
        const zoomPercentage = document.getElementById('zoomPercentage');
        
        if (modalContent) {
            modalContent.style.transform = `scale(${currentZoom}) translate(${panX * 0.5}px, ${panY * 0.5}px)`;
            
            if (currentZoom > 1) {
                modalContent.classList.add('zoomed');
            } else {
                modalContent.classList.remove('zoomed');
            }
        }
        
        if (zoomPercentage) {
            zoomPercentage.textContent = Math.round(currentZoom * 100) + '%';
        }
    }

    function initZoomHandlers() {
        const container = document.querySelector('.image-zoom-container');
        if (!container) return;

        // Remove old listeners to prevent duplicates
        const newContainer = container.cloneNode(true);
        container.parentNode.replaceChild(newContainer, container);

        // Mouse wheel zoom
        newContainer.addEventListener('wheel', (e) => {
            e.preventDefault();
            const delta = e.deltaY > 0 ? -0.05 : 0.05;
            zoomImage(delta);
        }, { passive: false });

        // Touch pinch zoom
        const hammer = new Hammer(newContainer);
        hammer.get('pinch').set({ enable: true });

        let initialZoom = 1;

        hammer.on('pinchstart', () => {
            initialZoom = currentZoom;
        });

        hammer.on('pinch', (e) => {
            const newZoom = initialZoom * e.scale;
            if (newZoom >= minZoom && newZoom <= maxZoom) {
                currentZoom = newZoom;
                updateModalZoom();
            }
        });

        // Pan/drag untuk menggeser modal
        let startX = 0;
        let startY = 0;

        newContainer.addEventListener('mousedown', (e) => {
            if (currentZoom > 1) {
                isPanning = true;
                startX = e.clientX - panX;
                startY = e.clientY - panY;
                newContainer.style.cursor = 'grabbing';
            }
        });

        document.addEventListener('mousemove', (e) => {
            if (isPanning && currentZoom > 1) {
                panX = e.clientX - startX;
                panY = e.clientY - startY;
                updateModalZoom();
            }
        });

        document.addEventListener('mouseup', () => {
            isPanning = false;
            newContainer.style.cursor = 'grab';
        });

        // Touch pan
        hammer.on('pan', (e) => {
            if (currentZoom > 1) {
                panX = e.deltaX;
                panY = e.deltaY;
                updateModalZoom();
            }
        });
    }

    // Close modal dengan Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });

    // Sortable Table untuk Pembayaran
    document.addEventListener('DOMContentLoaded', function() {
        const sortableHeaders = document.querySelectorAll('.table thead th.sortable');
        
        sortableHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const column = this.getAttribute('data-column');
                const table = document.getElementById('pembayaranTable');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                
                // Determine sort direction
                let isAscending = !this.classList.contains('asc');
                
                // Remove active class dari semua headers
                sortableHeaders.forEach(h => {
                    h.classList.remove('asc', 'desc');
                    h.querySelector('.sort-icon').textContent = '⇅';
                });
                
                // Add active class to current header
                this.classList.add(isAscending ? 'asc' : 'desc');
                this.querySelector('.sort-icon').textContent = isAscending ? '▲' : '▼';
                
                // Sort rows
                rows.sort((a, b) => {
                    let aValue = '';
                    let bValue = '';
                    
                    if (column === 'no') {
                        aValue = parseInt(a.getAttribute('data-no'));
                        bValue = parseInt(b.getAttribute('data-no'));
                    } else if (column === 'user_id') {
                        aValue = parseInt(a.getAttribute('data-user-id'));
                        bValue = parseInt(b.getAttribute('data-user-id'));
                    } else if (column === 'tipe') {
                        aValue = a.getAttribute('data-tipe').toLowerCase();
                        bValue = b.getAttribute('data-tipe').toLowerCase();
                    }
                    
                    // Compare
                    if (typeof aValue === 'number') {
                        return isAscending ? aValue - bValue : bValue - aValue;
                    } else {
                        return isAscending 
                            ? aValue.localeCompare(bValue) 
                            : bValue.localeCompare(aValue);
                    }
                });
                
                // Re-append sorted rows
                rows.forEach(row => tbody.appendChild(row));
            });
        });
    });
</script>

@endsection