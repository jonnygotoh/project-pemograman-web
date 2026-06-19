document.addEventListener('DOMContentLoaded', () => {
    if (window.lucide && typeof window.lucide.createIcons === 'function') {
        window.lucide.createIcons({ searchSelector: '[data-lucide]' });
    }

    let isClickScroll = false;

    // --- PENGATURAN ANIMASI SCROLL ---
    // Observer untuk trigger animasi saat section masuk viewport
    const animationObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('loaded-active');
                animationObserver.unobserve(entry.target); // Cukup trigger sekali saja
            }
        });
    }, { rootMargin: '0px 0px -60px 0px', threshold: 0.1 });

    // Observer untuk navigasi scroll tracking
   const navObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !isClickScroll) {
            setActiveNav(`#${entry.target.id}`);
        }
    });
}, {
    threshold: 0.3
});
    // Terapkan pemantauan ke semua elemen section
    document.querySelectorAll('section[id]').forEach(sec => {
        animationObserver.observe(sec);
        navObserver.observe(sec);
    });

    // --- LOGIKA KLIK MENU NAVIGASI ---
    document.querySelectorAll('.js-scroll-link, .brand').forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            if (!href || !href.startsWith('#')) return;

            const section = document.querySelector(href);
            if (!section) return;

            e.preventDefault();
            isClickScroll = true; // Kunci scroll spy agar navigasi stabil

            // --- LOGIKA RESET ANIMASI (Trigger Ulang) ---
            // Menghapus class lama dan memicu ulang transisi CSS
            section.classList.remove('loaded-active');
            void section.offsetWidth; // Trik agar browser memproses ulang DOM
            section.classList.add('loaded-active');
            // --------------------------------------------

            const navbarHeight = document.querySelector('.navbar')?.offsetHeight || 0;
            const targetPosition = section.getBoundingClientRect().top + window.pageYOffset - navbarHeight;

            window.scrollTo({ top: targetPosition, behavior: 'smooth' });
            setActiveNav(href);

            // Buka kembali kunci scroll setelah animasi selesai (1 detik)
            setTimeout(() => { isClickScroll = false; }, 1000);
        });
    });

    initSortableTables();

});

// Date Picker Calendar
document.addEventListener("DOMContentLoaded", function () {
    initDatePicker("seminar");
    initDatePicker("sertifikasi");
});

function initDatePicker(type) {
    const btn = document.getElementById(`${type}DatePickerBtn`);
    const dropdown = document.getElementById(`${type}DatePickerDropdown`);
    const monthYearText = document.getElementById(`${type}MonthYear`);
    const monthSelect = document.getElementById(`${type}MonthSelect`);
    const yearSelect = document.getElementById(`${type}YearSelect`);
    const goBtn = document.getElementById(`${type}GoDateBtn`);

    if (!btn || !dropdown || !monthYearText || !monthSelect || !yearSelect || !goBtn) return;

    const monthNames = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    let currentMonth = parseInt(btn.dataset.month);
    let currentYear = parseInt(btn.dataset.year);

    monthYearText.textContent = `${monthNames[currentMonth - 1]} ${currentYear}`;
    monthSelect.value = currentMonth;

    const realCurrentYear = new Date().getFullYear();

    yearSelect.innerHTML = "";

    for (let year = realCurrentYear - 1; year <= realCurrentYear + 1; year++) {
        const option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        option.selected = year === currentYear;
        yearSelect.appendChild(option);
    }

    btn.onclick = function (e) {
        e.stopPropagation();
        dropdown.classList.toggle("show");
    };

    goBtn.onclick = function (e) {
        e.stopPropagation();

        const selectedMonth = parseInt(monthSelect.value);
        const selectedYear = parseInt(yearSelect.value);

        changeMonth(type, selectedMonth, selectedYear);
        dropdown.classList.remove("show");
    };

    dropdown.onclick = function (e) {
        e.stopPropagation();
    };
}

document.addEventListener("click", function () {
    document.querySelectorAll(".calendar-picker-dropdown.show").forEach(function (dropdown) {
        dropdown.classList.remove("show");
    });
});

// Memuat data kalender baru secara AJAX
async function changeMonth(type, month, year) {
    try {
        const response = await fetch(`/calendar/${type}?month=${month}&year=${year}`);
        if (!response.ok) {
            const text = await response.text();
            console.error(`Gagal memuat kalender: HTTP ${response.status}`, text);
            return;
        }

        const html = await response.text();
        const el = document.getElementById(`${type}-calendar`);
        if (!el) return;

        el.innerHTML = html;
        initDatePicker(type);

        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            try {
                window.lucide.createIcons();
            } catch (err) {
                try {
                    window.lucide.createIcons && window.lucide.createIcons();
                } catch (e) {
                    console.warn('Lucide reinit failed', e);
                }
            }

            document.querySelectorAll(`#${type}-calendar [data-lucide]`).forEach(el => {
                el.style.visibility = 'visible';
            });
            document.querySelectorAll(`#${type}-calendar svg`).forEach(svg => {
                svg.style.visibility = 'visible';
            });
        }

    } catch (error) {
        console.error("Gagal memuat kalender:", error);
    }
}

// Mengatur class 'active' pada menu yang sedang terpilih
function setActiveNav(hash) {
    document.querySelectorAll('.js-scroll-link, .nav-menu a').forEach(link => {
        link.classList.toggle('active', link.getAttribute('href') === hash);
    });
}

// Mengganti tampilan antara Kalender dan Tabel
function switchView(type, view) {
    const calendar = document.getElementById(`${type}-calendar`);
    const table = document.getElementById(`${type}-table`);
    if (!calendar || !table) return;

    calendar.classList.toggle('hidden', view !== 'calendar');
    table.classList.toggle('hidden', view !== 'table');

    const section = document.getElementById(type);
    section?.querySelectorAll('.view-toggle button').forEach(btn => {
        btn.classList.remove('active');
        if (btn.getAttribute('onclick')?.includes(view)) btn.classList.add('active');
    });
}

function initSortableTables() {
    document.querySelectorAll('.responsive-table table').forEach(table => {
        const headers = table.querySelectorAll('thead th');
        headers.forEach((th, index) => {
            if (th.dataset.sortable === 'true') {
                th.classList.add('sortable');
                th.style.cursor = 'pointer';
                th.addEventListener('click', () => sortTableByColumn(table, index));
            }
        });
    });
}

function sortTableByColumn(table, columnIndex) {
    const tbody = table.tBodies[0];
    if (!tbody) return;

    const headers = table.querySelectorAll('thead th');
    const th = headers[columnIndex];
    if (!th || th.dataset.sortable !== 'true') return;

    const currentOrder = th.dataset.sortDirection === 'asc' ? 'desc' : 'asc';
    headers.forEach(header => {
        header.dataset.sortDirection = '';
        header.classList.remove('asc', 'desc', 'sort-active');
        const icon = header.querySelector('.sort-icon');
        if (icon) icon.textContent = '⇅';
        if (icon) icon.style.color = '#999';
    });
    
    th.dataset.sortDirection = currentOrder;
    th.classList.add(currentOrder);
    th.classList.add('sort-active');
    const activeIcon = th.querySelector('.sort-icon');
    if (activeIcon) {
        activeIcon.textContent = currentOrder === 'asc' ? '▲' : '▼';
        activeIcon.style.color = '#007bff';
        activeIcon.style.fontWeight = 'bold';
    }

    const rows = Array.from(tbody.querySelectorAll('tr'));
    const sortedRows = rows.sort((a, b) => {
        const aText = normalizeCellValue(a.cells[columnIndex]?.textContent || '');
        const bText = normalizeCellValue(b.cells[columnIndex]?.textContent || '');

        if (typeof aText === 'number' && typeof bText === 'number') {
            return currentOrder === 'asc' ? aText - bText : bText - aText;
        }

        if (typeof aText === 'string' && typeof bText === 'string') {
            return currentOrder === 'asc'
                ? aText.localeCompare(bText, 'id', { numeric: true })
                : bText.localeCompare(aText, 'id', { numeric: true });
        }

        return 0;
    });

    sortedRows.forEach(row => tbody.appendChild(row));
}

function normalizeCellValue(value) {
    const trimmed = value.trim();
    if (!trimmed) return '';

    const numericValue = trimmed
        .replace(/[Rp\s]/g, '')
        .replace(/\./g, '')
        .replace(/,/g, '.');
    if (/^-?\d+(\.\d+)?$/.test(numericValue)) {
        return parseFloat(numericValue);
    }

    const dateValue = parseIndonesianDate(trimmed);
    if (dateValue !== null) {
        return dateValue;
    }

    return trimmed.toLowerCase();
}

function parseIndonesianDate(value) {
    const monthMap = {
        januari: 0, februari: 1, maret: 2, april: 3, mei: 4, juni: 5,
        juli: 6, agustus: 7, september: 8, oktober: 9, november: 10, desember: 11
    };

    const rangeMatch = value.match(/(\d{1,2}\s+[A-Za-z]+\s+\d{4})/gi);
    if (rangeMatch && rangeMatch.length > 0) {
        return parseSingleDate(rangeMatch[0], monthMap);
    }

    const monthYearMatch = value.match(/^(?:\d{1,2}\s+)?([A-Za-z]+)\s+(\d{4})$/i);
    if (monthYearMatch) {
        return parseSingleDate(`1 ${monthYearMatch[1]} ${monthYearMatch[2]}`, monthMap);
    }

    return null;
}

function parseSingleDate(dateString, monthMap) {
    const cleaned = dateString.trim().toLowerCase();
    const match = cleaned.match(/(\d{1,2})\s+([a-zA-Z]+)\s+(\d{4})/);
    if (!match) return null;

    const day = parseInt(match[1], 10);
    const month = monthMap[match[2]];
    const year = parseInt(match[3], 10);
    if (month === undefined || Number.isNaN(day) || Number.isNaN(year)) return null;

    return new Date(year, month, day).getTime();
}

function applyPicker(type) {
    const month = document.getElementById(`m-${type}`).value;
    const year = document.getElementById(`y-${type}`).value;
    
    // Memanggil fungsi changeMonth original Anda
    // Kita panggil langsung dengan 3 parameter
    changeMonth(type, month, year);
    
    // Tutup dropdown
    toggleDropdown(`picker-${type}`);
}

// Membuka/menutup menu dropdown
function toggleDropdown(id) {
    document.getElementById(id)?.classList.toggle('show');
}

// Mengganti tab pada profil
function switchProfileTab(tab) {
    const seminarPanel = document.getElementById('profile-seminar-panel');
    const sertifikasiPanel = document.getElementById('profile-sertifikasi-panel');
    if (!seminarPanel || !sertifikasiPanel) return;

    seminarPanel.classList.toggle('hidden', tab !== 'seminar');
    sertifikasiPanel.classList.toggle('hidden', tab !== 'sertifikasi');

    const tabsContainer = document.querySelector('.registered-card .tabs');
    if (tabsContainer) {
        tabsContainer.querySelectorAll('button').forEach((btn, index) => {
            btn.classList.toggle('active', (tab === 'seminar' && index === 0) || (tab === 'sertifikasi' && index === 1));
        });
    }
    setTimeout(() => {
        if (typeof initUnifiedPagination === 'function') {
            initUnifiedPagination();
        }
    }, 50);
}

// Menutup menu saat klik di luar area
window.addEventListener('click', function(e) {
    const navMenu = document.getElementById('navMenu');
    const accountMenu = document.getElementById('accountMenu');
    const menuBtn = document.querySelector('.mobile-menu-btn');
    const accountBtn = document.querySelector('.account-btn');

    if (navMenu && !navMenu.contains(e.target) && !menuBtn?.contains(e.target)) navMenu.classList.remove('show');
    if (accountMenu && !accountMenu.contains(e.target) && !accountBtn?.contains(e.target)) accountMenu.classList.remove('show');

});

function openTokenModal(id) {
    document.getElementById('modal_seminar_id').value = id;
    document.getElementById('tokenModal').style.display = 'block';
}
/* ==================================================
   TABLE PAGINATION & SORTING
================================================== */

document.addEventListener("DOMContentLoaded", () => {
    initTablePagination();
});

function initTablePagination() {
    document.querySelectorAll(".table-card").forEach(tableCard => {

        const tbody = tableCard.querySelector(".paginated-body");
        if (!tbody) return;

        const rows = Array.from(tbody.querySelectorAll("tr"));
        if (!rows.length) return;

        const pageNumbers = tableCard.querySelector(".page-numbers");
        const prevBtn = tableCard.querySelector(".prev-btn");
        const nextBtn = tableCard.querySelector(".next-btn");
        const entriesInfo = tableCard.querySelector(".entries-info");
        const entriesDropdown = tableCard.querySelector(".entries-dropdown");

        let rowsPerPage = entriesDropdown ? parseInt(entriesDropdown.value) : 25;
        
        // Handle entries dropdown change
        if (entriesDropdown) {
            entriesDropdown.addEventListener('change', (e) => {
                rowsPerPage = parseInt(e.target.value);
                currentPage = 1;
                showPage(1);
            });
        }

        // Hitung total halaman secara dinamis
        let totalPages = Math.ceil(rows.length / rowsPerPage);

        let currentPage = 1;

        function showPage(page) {
            currentPage = page;
            
            // Recalculate totalPages berdasarkan rowsPerPage yang sekarang
            totalPages = Math.ceil(rows.length / rowsPerPage);

            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                row.style.display = (index >= start && index < end) ? "" : "none";
            });

            // Update Teks "Showing X to Y of Z entries"
            if (entriesInfo) {
                const showingStart = (rows.length > 0) ? start + 1 : 0;
                const showingEnd = Math.min(end, rows.length);
                entriesInfo.textContent = `Showing ${showingStart} to ${showingEnd} of ${rows.length} entries`;
            }

            renderPagination();
        }

        function renderPagination() {
            pageNumbers.innerHTML = "";

            // Loop untuk membuat tombol angka halaman
            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement("button");
                btn.textContent = i;
                btn.className = (i === currentPage) ? "page-btn active" : "page-btn";
                btn.addEventListener("click", () => showPage(i));
                pageNumbers.appendChild(btn);
            }

            // Status tombol Prev/Next
            prevBtn.disabled = (currentPage === 1);
            nextBtn.disabled = (currentPage === totalPages || totalPages === 0);
        }

        // Event Listener Tombol Navigasi
        prevBtn.addEventListener("click", () => {
            if (currentPage > 1) showPage(currentPage - 1);
        });

        nextBtn.addEventListener("click", () => {
            if (currentPage < totalPages) showPage(currentPage + 1);
        });

        // Inisialisasi halaman pertama
        showPage(1);
    });
}

function setupTable(tableCard) {
    const tbody = tableCard.querySelector('.paginated-body');
    const searchInput = tableCard.querySelector('.table-search-input');
    const entriesDropdown = tableCard.querySelector('.entries-dropdown');
    const allRows = Array.from(tbody.querySelectorAll('tr'));
    
    // Simpan referensi ke tombol
    const prevBtn = tableCard.querySelector('.prev-btn');
    const nextBtn = tableCard.querySelector('.next-btn');
    let currentPage = 1;

    function render() {
        const searchTerm = searchInput.value.toLowerCase();
        const rowsPerPage = parseInt(entriesDropdown.value);

        // 1. Filter data
        const filteredRows = allRows.filter(row => 
            row.textContent.toLowerCase().includes(searchTerm)
        );

        // 2. Hitung total halaman
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage) || 1;
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        // 3. Tampilkan data dengan cara yang lebih stabil
        // Sembunyikan semua baris
        allRows.forEach(row => row.style.display = 'none');
        
        // Tampilkan hanya baris yang sesuai halaman dan filter
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        
        filteredRows.slice(start, end).forEach(row => {
            row.style.display = ''; // Browser akan mengembalikan ke 'table-row' secara otomatis
        });

        // 4. Update UI
        const info = tableCard.querySelector('.entries-info');
        info.textContent = filteredRows.length > 0 
            ? `Showing ${start + 1} to ${Math.min(end, filteredRows.length)} of ${filteredRows.length} entries`
            : "Showing 0 to 0 of 0 entries";
            
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage >= totalPages;
    }

    // Gunakan event 'input' agar lebih smooth
    searchInput.addEventListener('input', () => {
        currentPage = 1; // Reset ke halaman 1
        render();
    });

    entriesDropdown.addEventListener('change', () => {
        currentPage = 1;
        render();
    });

    prevBtn.addEventListener('click', () => { currentPage--; render(); });
    nextBtn.addEventListener('click', () => { currentPage++; render(); });

    render();
}

// Fungsi untuk konfirmasi pendaftaran
function confirmDaftar(url, roleLabel) {
    Swal.fire({
        title: 'sertifikasi.uib.ac.id says',
        text: "Apakah anda yakin ingin mendaftar sebagai Peserta " + roleLabel + " ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}

function confirmDaftarSeminar(formId = 'form-seminar') {
    Swal.fire({
        title: 'sertifikasi.uib.ac.id says',
        text: 'Apakah anda yakin ingin mendaftar seminar ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            const f = document.getElementById(formId);
            if (f) {
                f.submit(); // Langsung submit, biarkan Laravel yang memberi pesan sukses
            }
        }
    });
}

function confirmAddRemove({
    formId,
    text,
    confirmText = 'OK',
    cancelText = 'Batal',
    icon = 'question',
    confirmColor = '#001A72',
    cancelColor = '#6c757d'
}) {
    Swal.fire({
        title: 'sertifikasi.uib.ac.id says',
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        reverseButtons: true,
        confirmButtonColor: confirmColor,
        cancelButtonColor: cancelColor
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId)?.submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initTableSearch();
});

document.addEventListener('DOMContentLoaded', () => {
    // Jalankan sistem satu pintu
    document.querySelectorAll('.table-card').forEach(tableCard => {
        const tbody = tableCard.querySelector('.paginated-body');
        if (!tbody) return;
        
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const searchInput = tableCard.querySelector('.table-search-input');
        const entriesDropdown = tableCard.querySelector('.entries-dropdown');
        const prevBtn = tableCard.querySelector('.prev-btn');
        const nextBtn = tableCard.querySelector('.next-btn');
        const pageNumbers = tableCard.querySelector('.page-numbers');
        const info = tableCard.querySelector('.entries-info');

        let currentPage = 1;

        const refreshTable = (page = 1) => {
            currentPage = page;
            const searchTerm = searchInput ? searchInput.value.toLowerCase() : "";
            const rowsPerPage = entriesDropdown ? parseInt(entriesDropdown.value) : 10;

            // 1. FILTER: Cari data
            const filteredRows = rows.filter(row => 
                row.textContent.toLowerCase().includes(searchTerm)
            );

            // 2. PAGINASI: Tentukan halaman
            const totalPages = Math.ceil(filteredRows.length / rowsPerPage) || 1;
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            // 3. Tampilkan/Sembunyikan
            rows.forEach(r => r.style.display = 'none');
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            filteredRows.slice(start, end).forEach(r => r.style.display = '');

            // 4. Update Info Text
            const showingStart = filteredRows.length > 0 ? (currentPage - 1) * rowsPerPage + 1 : 0;
            const showingEnd = Math.min(currentPage * rowsPerPage, filteredRows.length);
            if (info) info.textContent = `Showing ${showingStart} to ${showingEnd} of ${filteredRows.length} entries`;

            // 5. Render Tombol Angka
            if (pageNumbers) {
                pageNumbers.innerHTML = "";
                for (let i = 1; i <= totalPages; i++) {
                    const btn = document.createElement("button");
                    btn.textContent = i;
                    btn.className = `page-btn ${i === currentPage ? 'active' : ''}`;
                    btn.onclick = () => refreshTable(i);
                    pageNumbers.appendChild(btn);
                }
            }

            if (prevBtn) prevBtn.disabled = (currentPage === 1);
            if (nextBtn) nextBtn.disabled = (currentPage >= totalPages);
        };

        // Event Listeners (hanya satu kali pasang)
        if (searchInput) searchInput.addEventListener('input', () => refreshTable(1));
        if (entriesDropdown) entriesDropdown.addEventListener('change', () => refreshTable(1));
        if (prevBtn) prevBtn.addEventListener('click', () => refreshTable(currentPage - 1));
        if (nextBtn) nextBtn.addEventListener('click', () => refreshTable(currentPage + 1));
        
        refreshTable(1);
    });
});