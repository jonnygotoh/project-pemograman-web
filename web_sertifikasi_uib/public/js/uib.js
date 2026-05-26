document.addEventListener('DOMContentLoaded', () => {

    window.lucide?.createIcons();

    let isClickScroll = false;

    // CLICK SCROLL
    document.querySelectorAll('.js-scroll-link').forEach(link => {
        link.addEventListener('click', (e) => {

            const target = link.getAttribute('href');
            if (!target?.startsWith('#')) return;

            e.preventDefault();

            const section = document.querySelector(target);
            if (!section) return;

            isClickScroll = true;

            section.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

            setActiveNav(target);

            setTimeout(() => isClickScroll = false, 600);
        });
    });

    // SCROLL SPY
    const sections = document.querySelectorAll('section[id]');

    const observer = new IntersectionObserver((entries) => {

        if (isClickScroll) return;

        entries.forEach(entry => {
            if (entry.isIntersecting) {
                setActiveNav(`#${entry.target.id}`);
            }
        });

    }, {
        rootMargin: '-40% 0px -40% 0px'
    });

    sections.forEach(sec => observer.observe(sec));
});


// ACTIVE MENU
function setActiveNav(hash) {
    document.querySelectorAll('.js-scroll-link').forEach(link => {
        link.classList.toggle(
            'active',
            link.getAttribute('href') === hash
        );
    });
}


// SWITCH VIEW
function switchView(type, view) {

    const calendar = document.getElementById(`${type}-calendar`);
    const table = document.getElementById(`${type}-table`);

    if (!calendar || !table) return;

    calendar.classList.toggle('hidden', view !== 'calendar');
    table.classList.toggle('hidden', view !== 'table');

    const section = document.getElementById(type);

    section?.querySelectorAll('.view-toggle button')
        .forEach(btn => btn.classList.remove('active'));

    section?.querySelectorAll('.view-toggle button')
        [view === 'calendar' ? 0 : 1]
        ?.classList.add('active');
}

async function changeMonth(type, month, year) {

    try {

        const response = await fetch(
            `/calendar/${type}?month=${month}&year=${year}`
        );

        const html = await response.text();

        const el = document.getElementById(`${type}-calendar`);

        if (!el) return;

        el.innerHTML = html;

        // re-init icons
        if (window.lucide) {
            lucide.createIcons();
        }

    } catch (error) {
        console.error('Gagal load calendar:', error);
    }
}

// DROPDOWN
function toggleDropdown(id) {
    document.getElementById(id)?.classList.toggle('show');
}

// SWITCH PROFILE TAB
function switchProfileTab(tab) {
    // 1. Ambil elemen panel tabel
    const seminarPanel = document.getElementById('profile-seminar-panel');
    const sertifikasiPanel = document.getElementById('profile-sertifikasi-panel');

    if (!seminarPanel || !sertifikasiPanel) return;

    // 2. Sembunyikan atau tampilkan panel berdasarkan parameter 'tab'
    seminarPanel.classList.toggle('hidden', tab !== 'seminar');
    sertifikasiPanel.classList.toggle('hidden', tab !== 'sertifikasi');

    // 3. Atur tombol mana yang sedang 'active' (berwarna)
    const tabsContainer = document.querySelector('.registered-card .tabs');
    if (tabsContainer) {
        const buttons = tabsContainer.querySelectorAll('button');
        buttons.forEach(btn => btn.classList.remove('active'));

        // Tombol index [0] untuk seminar, [1] untuk sertifikasi
        if (tab === 'seminar' && buttons[0]) buttons[0].classList.add('active');
        if (tab === 'sertifikasi' && buttons[1]) buttons[1].classList.add('active');
    }
}