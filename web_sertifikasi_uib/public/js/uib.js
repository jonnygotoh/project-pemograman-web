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