/**
 * TaskFlow – Aplikasi Manajemen Tugas Mahasiswa (Laravel Edition)
 * Main JavaScript File
 */

document.addEventListener('DOMContentLoaded', function () {
    // -------------------------------------------------------------
    // 1. Inisialisasi Modal Konfirmasi Hapus
    // -------------------------------------------------------------
    const deleteModalEl = document.getElementById('deleteConfirmModal');
    if (deleteModalEl) {
        const deleteForm = document.getElementById('deleteTaskForm');
        const taskTitleEl = document.getElementById('deleteTaskTitle');

        deleteModalEl.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const taskId = button.getAttribute('data-task-id');
            const taskTitle = button.getAttribute('data-task-title');

            if (taskTitleEl) {
                taskTitleEl.textContent = taskTitle || 'Tugas ini';
            }
            if (deleteForm) {
                deleteForm.setAttribute('action', `/tasks/${taskId}`);
            }
        });
    }

    // -------------------------------------------------------------
    // 2. Auto-Dismiss Alert Notifikasi setelah 4 detik
    // -------------------------------------------------------------
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) {
                bsAlert.close();
            }
        }, 4000);
    });

    // -------------------------------------------------------------
    // 3. Switcher Tampilan (Tabel vs Card)
    // -------------------------------------------------------------
    const tableViewBtn = document.getElementById('btnViewTable');
    const cardViewBtn = document.getElementById('btnViewCard');
    const tableViewContainer = document.getElementById('tableViewContainer');
    const cardViewContainer = document.getElementById('cardViewContainer');

    if (tableViewBtn && cardViewBtn && tableViewContainer && cardViewContainer) {
        // Cek preferensi user dari localStorage
        const savedView = localStorage.getItem('taskflow_laravel_view') || 'table';
        if (savedView === 'card') {
            setViewMode('card');
        } else {
            setViewMode('table');
        }

        tableViewBtn.addEventListener('click', function () {
            setViewMode('table');
        });

        cardViewBtn.addEventListener('click', function () {
            setViewMode('card');
        });

        function setViewMode(mode) {
            if (mode === 'card') {
                tableViewContainer.classList.add('d-none');
                cardViewContainer.classList.remove('d-none');
                cardViewBtn.classList.add('active', 'btn-primary');
                cardViewBtn.classList.remove('btn-outline-secondary');
                tableViewBtn.classList.remove('active', 'btn-primary');
                tableViewBtn.classList.add('btn-outline-secondary');
                localStorage.setItem('taskflow_laravel_view', 'card');
            } else {
                cardViewContainer.classList.add('d-none');
                tableViewContainer.classList.remove('d-none');
                tableViewBtn.classList.add('active', 'btn-primary');
                tableViewBtn.classList.remove('btn-outline-secondary');
                cardViewBtn.classList.remove('active', 'btn-primary');
                cardViewBtn.classList.add('btn-outline-secondary');
                localStorage.setItem('taskflow_laravel_view', 'table');
            }
        }
    }

    // -------------------------------------------------------------
    // 4. Client-side Realtime Quick Search (Penyaring Cepat)
    // -------------------------------------------------------------
    const clientSearchInput = document.querySelector('.search-input-group input');
    if (clientSearchInput) {
        clientSearchInput.addEventListener('input', function (e) {
            const keyword = e.target.value.toLowerCase().trim();
            
            // Filter baris tabel
            const rows = document.querySelectorAll('#tasksTableBody tr.task-row');
            rows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(keyword) ? '' : 'none';
            });

            // Filter kartu
            const cards = document.querySelectorAll('.task-card-item');
            cards.forEach(function (card) {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(keyword) ? '' : 'none';
            });
        });
    }

    // -------------------------------------------------------------
    // 5. Tooltip Bootstrap Initialization
    // -------------------------------------------------------------
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

