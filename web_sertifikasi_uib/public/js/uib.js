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
    }, { rootMargin: '-30% 0px -60% 0px', threshold: 0.1 });

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
        header.classList.remove('asc', 'desc');
        const icon = header.querySelector('.sort-icon');
        if (icon) icon.textContent = '↕';
    });
    th.dataset.sortDirection = currentOrder;
    th.classList.add(currentOrder);
    const activeIcon = th.querySelector('.sort-icon');
    if (activeIcon) activeIcon.textContent = currentOrder === 'asc' ? '▲' : '▼';

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