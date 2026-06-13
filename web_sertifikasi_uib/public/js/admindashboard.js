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

    // Sortable Table untuk Pembayaran dan Verifikasi Seminar
    document.addEventListener('DOMContentLoaded', function() {
        const sortableHeaders = document.querySelectorAll('.table thead th.sortable');
        
        sortableHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const column = this.getAttribute('data-column');
                const table = this.closest('table');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                
                // Determine sort direction
                let isAscending = !this.classList.contains('asc');
                
                // Remove active class dari semua headers di table ini
                table.querySelectorAll('th.sortable').forEach(h => {
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
                        aValue = parseInt(a.getAttribute('data-no') || 0);
                        bValue = parseInt(b.getAttribute('data-no') || 0);
                    } else if (column === 'user_id') {
                        aValue = parseInt(a.getAttribute('data-user-id') || 0);
                        bValue = parseInt(b.getAttribute('data-user-id') || 0);
                    } else if (column === 'tipe') {
                        aValue = a.getAttribute('data-tipe')?.toLowerCase() || '';
                        bValue = b.getAttribute('data-tipe')?.toLowerCase() || '';
                    } else if (column === 'nama') {
                        aValue = a.getAttribute('data-nama')?.toLowerCase() || '';
                        bValue = b.getAttribute('data-nama')?.toLowerCase() || '';
                    } else if (column === 'npm') {
                        aValue = a.getAttribute('data-npm')?.toLowerCase() || '';
                        bValue = b.getAttribute('data-npm')?.toLowerCase() || '';
                    } else if (column === 'tanggal') {
                        aValue = a.getAttribute('data-tanggal') || '';
                        bValue = b.getAttribute('data-tanggal') || '';
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
