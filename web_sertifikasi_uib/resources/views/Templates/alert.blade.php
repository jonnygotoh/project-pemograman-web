<div id="modalOverlay" class="modal-overlay hidden">
    <div class="modal-card" id="modalCard">
        <button class="modal-close hidden" id="modalClose" onclick="closeModal()"><i data-lucide="x"></i></button>
        <div id="modalIcon" class="modal-icon success"><i data-lucide="check"></i></div>
        <h2 id="modalTitle">Success</h2>
        <p id="modalMessage">Message</p>

        <div id="modalInputArea" class="hidden">
            <label id="modalInputLabel">Input</label>
            <small id="modalInputHelp"></small>
            <input id="modalInput" class="form-control" placeholder="Masukkan token di sini">
        </div>

        <div class="modal-actions" id="modalActions">
            <button class="btn-primary" onclick="closeModal()">OK</button>
        </div>
    </div>
</div>
