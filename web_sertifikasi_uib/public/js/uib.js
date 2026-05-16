document.addEventListener('DOMContentLoaded', () => {
    if (window.lucide) lucide.createIcons();

    document.querySelectorAll('.js-scroll-link').forEach(link => {
        link.addEventListener('click', function (event) {
            const target = this.getAttribute('href');

            if (!target || !target.startsWith('#')) return;

            event.preventDefault();

            const section = document.querySelector(target);
            if (!section) return;

            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
            setActiveNav(target);

            const navMenu = document.getElementById('navMenu');
            navMenu?.classList.remove('show');
        });
    });

    const sections = document.querySelectorAll('section[id]');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                setActiveNav(`#${entry.target.id}`);
            }
        });
    }, { rootMargin: '-35% 0px -55% 0px' });

    sections.forEach(section => observer.observe(section));
});

function setActiveNav(hash) {
    document.querySelectorAll('.nav-menu a[href^="#"]').forEach(link => {
        link.classList.toggle('active', link.getAttribute('href') === hash);
    });
}

function toggleDropdown(id){
    document.getElementById(id)?.classList.toggle('show');
}

function switchView(type, view){
    const calendar = document.getElementById(`${type}-calendar`);
    const table = document.getElementById(`${type}-table`);

    if (!calendar || !table) return;

    calendar.classList.toggle('hidden', view !== 'calendar');
    table.classList.toggle('hidden', view !== 'table');

    const section = document.getElementById(type === 'seminar' ? 'seminar' : 'sertifikasi');
    section?.querySelectorAll('.view-toggle button').forEach(btn => btn.classList.remove('active'));

    const index = view === 'calendar' ? 0 : 1;
    section?.querySelectorAll('.view-toggle button')[index]?.classList.add('active');

    if (window.lucide) lucide.createIcons();
}

function closeModal(){
    document.getElementById('modalOverlay').classList.add('hidden');
}

function baseModal({title, message, icon='check', type='success', actions='', showClose=false, input=false, inputLabel='', inputHelp=''}){
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalMessage').innerText = message;
    document.getElementById('modalIcon').className = `modal-icon ${type}`;
    document.getElementById('modalIcon').innerHTML = `<i data-lucide="${icon}"></i>`;
    document.getElementById('modalActions').innerHTML = actions || `<button class="btn-primary" onclick="closeModal()">OK</button>`;
    document.getElementById('modalClose').classList.toggle('hidden', !showClose);

    const inputArea = document.getElementById('modalInputArea');
    inputArea.classList.toggle('hidden', !input);
    document.getElementById('modalInputLabel').innerText = inputLabel;
    document.getElementById('modalInputHelp').innerText = inputHelp;

    document.getElementById('modalOverlay').classList.remove('hidden');
    if (window.lucide) lucide.createIcons();
}

function openLoginRequired(){
    baseModal({
        title:'Oops...',
        message:'Mohon untuk login terlebih dahulu !',
        icon:'circle-alert',
        type:'warning'
    });
}

function openSuccess(message='Anda berhasil mendaftar'){
    baseModal({
        title:'',
        message,
        icon:'check',
        type:'success'
    });
}

function openConfirmRegister(){
    baseModal({
        title:'sertifikasi.uib.ac.id says',
        message:'Apakah anda yakin ingin mendaftar sebagai Peserta Mahasiswa ?',
        icon:'circle-alert',
        type:'warning',
        actions:`<button class="btn-primary" onclick="closeModal(); openSuccess('Anda berhasil mendaftar')">OK</button>
                 <button class="btn-cancel" onclick="closeModal()">Cancel</button>`
    });
}

function openAttendanceToken(){
    baseModal({
        title:'Daftar hadir',
        message:'',
        icon:'check',
        type:'success',
        showClose:true,
        input:true,
        inputLabel:'Isikan token absensi',
        inputHelp:'Token diumumkan pada saat acara*',
        actions:`<button class="btn-dark" onclick="closeModal(); openSuccess('Terima kasih telah berpartisipasi')">Simpan</button>`
    });
}
