@extends('layouts.app')

@section('title', 'Dashboard – TaskFlow Laravel')

@section('content')
<!-- HEADER DASHBOARD -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="h3 fw-bold mb-1" style="color: var(--primary-navy);">
            <i class="bi bi-grid-1x2-fill text-primary me-2"></i>Dashboard Tugas Kuliah
        </h2>
        <p class="text-muted mb-0">
            Kelola dan pantau seluruh deadline tugas akademik Anda secara terorganisir.
        </p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('tasks.create') }}" class="btn btn-primary-azure d-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-plus-circle-fill fs-6"></i>
            <span>Tambah Tugas Baru</span>
        </a>
    </div>
</div>

<!-- STATISTIK KARTU -->
<div class="row g-3 mb-4">
    <!-- Total Tugas -->
    <div class="col-6 col-lg-3">
        <div class="stat-card total">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Total Tugas</span>
                <div class="stat-icon total">
                    <i class="bi bi-journal-text"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <small class="text-muted">Semua tugas terdaftar</small>
        </div>
    </div>

    <!-- Sedang Dikerjakan -->
    <div class="col-6 col-lg-3">
        <div class="stat-card in-progress">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Sedang Dikerjakan</span>
                <div class="stat-icon in-progress">
                    <i class="bi bi-hourglass-split"></i>
                </div>
            </div>
            <div class="stat-value text-primary">{{ $stats['in_progress'] }}</div>
            <small class="text-muted">Dalam proses pengerjaan</small>
        </div>
    </div>

    <!-- Belum Dikerjakan -->
    <div class="col-6 col-lg-3">
        <div class="stat-card pending">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Belum Dikerjakan</span>
                <div class="stat-icon pending">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
            <div class="stat-value text-warning">{{ $stats['pending'] }}</div>
            <small class="text-muted">Menunggu pengerjaan</small>
        </div>
    </div>

    <!-- Selesai -->
    <div class="col-6 col-lg-3">
        <div class="stat-card completed">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Selesai</span>
                <div class="stat-icon completed">
                    <i class="bi bi-check2-circle"></i>
                </div>
            </div>
            <div class="stat-value text-success">{{ $stats['completed'] }}</div>
            <small class="text-muted">{{ $stats['completion_rate'] }}% terselesaikan</small>
        </div>
    </div>
</div>

<!-- PROGRESS BAR PENYELESAIAN TUGAS -->
@if ($stats['total'] > 0)
<div class="card border-0 shadow-sm p-3 mb-4" style="border-radius: var(--radius-md);">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="fw-semibold text-secondary small">
            <i class="bi bi-graph-up-arrow me-1 text-primary"></i> Tingkat Penyelesaian Tugas
        </span>
        <span class="fw-bold small text-primary">{{ $stats['completed'] }} dari {{ $stats['total'] }} Tugas ({{ $stats['completion_rate'] }}%)</span>
    </div>
    <div class="progress" style="height: 10px; border-radius: 6px;">
        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $stats['completion_rate'] }}%;" aria-valuenow="{{ $stats['completion_rate'] }}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>
@endif

<!-- TOOLBAR: FILTER, SEARCH, & VIEW TOGGLER -->
<div class="filter-card">
    <form method="GET" action="{{ route('tasks.index') }}" class="row g-2 align-items-center">
        <!-- Input Pencarian -->
        <div class="col-12 col-md-4">
            <div class="search-input-group">
                <i class="bi bi-search"></i>
                <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari judul, mata kuliah, deskripsi..." value="{{ $searchQuery }}">
            </div>
        </div>

        <!-- Filter Status -->
        <div class="col-6 col-md-3">
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                @foreach (\App\Models\Task::VALID_STATUSES as $st)
                    <option value="{{ $st }}" {{ $statusFilter === $st ? 'selected' : '' }}>{{ $st }}</option>
                @endforeach
            </select>
        </div>

        <!-- Sorting -->
        <div class="col-6 col-md-3">
            <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="deadline" {{ $sortBy === 'deadline' ? 'selected' : '' }}>Deadline Terdekat</option>
                <option value="deadline_desc" {{ $sortBy === 'deadline_desc' ? 'selected' : '' }}>Deadline Terjauh</option>
                <option value="created_desc" {{ $sortBy === 'created_desc' ? 'selected' : '' }}>Terbaru Ditambahkan</option>
                <option value="title" {{ $sortBy === 'title' ? 'selected' : '' }}>Judul (A-Z)</option>
            </select>
        </div>

        <!-- Tombol Aksi Filter & View Mode -->
        <div class="col-12 col-md-2 d-flex justify-content-between justify-content-md-end gap-2">
            <div class="d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary-azure" title="Terapkan Filter">
                    <i class="bi bi-funnel-fill"></i>
                </button>
                @if ($searchQuery || $statusFilter || $sortBy !== 'deadline')
                    <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset Filter">
                        <i class="bi bi-x-circle"></i>
                    </a>
                @endif
            </div>

            <div class="btn-group btn-group-sm" role="group" aria-label="View Switcher">
                <button type="button" class="btn btn-outline-secondary active" id="btnViewTable" title="Tampilan Tabel">
                    <i class="bi bi-table"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="btnViewCard" title="Tampilan Kartu">
                    <i class="bi bi-grid-fill"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- DAFTAR TUGAS -->
@if ($tasks->count() > 0)
    <!-- 1. TAMPILAN TABEL -->
    <div id="tableViewContainer" class="table-card shadow-sm">
        <div class="table-responsive">
            <table class="table table-custom align-middle">
                <thead>
                    <tr>
                        <th style="width: 50px;" class="text-center">No</th>
                        <th>Tugas & Mata Kuliah</th>
                        <th style="width: 170px;">Deadline</th>
                        <th style="width: 180px;">Status</th>
                        <th style="width: 120px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tasksTableBody">
                    @foreach ($tasks as $task)
                    <tr class="task-row">
                        <td class="text-center text-muted fw-semibold">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex flex-column">
                                <div class="task-title">{{ $task->title }}</div>
                                @if ($task->description)
                                    <div class="task-desc">{{ $task->description }}</div>
                                @endif
                                <div class="mt-1">
                                    @if ($task->course)
                                        <span class="badge-course">
                                            <i class="bi bi-book me-1"></i>{{ $task->course }}
                                        </span>
                                    @else
                                        <span class="text-muted small italic">Umum</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            @if ($task->deadline)
                                <div class="d-flex flex-column align-items-start gap-1">
                                    <span class="fw-semibold small">
                                        <i class="bi bi-calendar-event me-1 text-primary"></i>
                                        {{ $task->formatted_deadline }}
                                    </span>
                                    @if ($task->is_overdue)
                                        <span class="badge-overdue">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Terlewat
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted small">Tidak ada deadline</span>
                            @endif
                        </td>
                        <td>
                            <!-- Quick Status Update Dropdown -->
                            <form action="{{ route('tasks.updateStatus', $task) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <div class="dropdown">
                                    <button class="btn btn-sm badge-status {{ $task->status_badge_class }} border-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        @if ($task->status === 'Selesai')
                                            <i class="bi bi-check-circle-fill"></i>
                                        @elseif ($task->status === 'Sedang Dikerjakan')
                                            <i class="bi bi-arrow-repeat"></i>
                                        @else
                                            <i class="bi bi-clock-fill"></i>
                                        @endif
                                        {{ $task->status }}
                                    </button>
                                    <ul class="dropdown-menu shadow-sm">
                                        <li><h6 class="dropdown-header small text-muted">Ubah Status Tugas</h6></li>
                                        <li>
                                            <button type="submit" name="status" value="Belum Dikerjakan" class="dropdown-item small d-flex align-items-center gap-2">
                                                <i class="bi bi-clock text-warning"></i> Belum Dikerjakan
                                            </button>
                                        </li>
                                        <li>
                                            <button type="submit" name="status" value="Sedang Dikerjakan" class="dropdown-item small d-flex align-items-center gap-2">
                                                <i class="bi bi-arrow-repeat text-primary"></i> Sedang Dikerjakan
                                            </button>
                                        </li>
                                        <li>
                                            <button type="submit" name="status" value="Selesai" class="dropdown-item small d-flex align-items-center gap-2">
                                                <i class="bi bi-check2-circle text-success"></i> Selesai
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <!-- Tombol Edit -->
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="tooltip" data-bs-title="Edit Tugas">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <!-- Tombol Hapus (Triggers Modal) -->
                                <button type="button" class="btn btn-sm btn-outline-danger action-btn" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal" data-task-id="{{ $task->id }}" data-task-title="{{ $task->title }}" title="Hapus Tugas">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. TAMPILAN KARTU (CARD VIEW) -->
    <div id="cardViewContainer" class="d-none">
        <div class="row g-3">
            @foreach ($tasks as $task)
            <div class="col-12 col-md-6 col-lg-4 task-card-item">
                <div class="card h-100 shadow-sm border" style="border-radius: var(--radius-md);">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            @if ($task->course)
                                <span class="badge-course">{{ $task->course }}</span>
                            @else
                                <span class="text-muted small">Umum</span>
                            @endif
                            <span class="badge-status {{ $task->status_badge_class }}">
                                {{ $task->status }}
                            </span>
                        </div>

                        <h5 class="fw-bold mb-2" style="color: var(--primary-navy);">{{ $task->title }}</h5>
                        
                        @if ($task->description)
                            <p class="text-muted small mb-3 flex-grow-1" style="line-height: 1.5;">
                                {{ $task->description }}
                            </p>
                        @else
                            <p class="text-muted small mb-3 fst-italic flex-grow-1">Tidak ada deskripsi tambahan.</p>
                        @endif

                        <div class="pt-2 border-top mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="small">
                                    <i class="bi bi-calendar3 text-primary me-1"></i>
                                    @if ($task->deadline)
                                        <span class="fw-medium">{{ $task->formatted_deadline }}</span>
                                        @if ($task->is_overdue)
                                            <span class="badge-overdue ms-1">Terlewat</span>
                                        @endif
                                    @else
                                        <span class="text-muted">Tidak ada deadline</span>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <form action="{{ route('tasks.updateStatus', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle py-1 px-2 small" type="button" data-bs-toggle="dropdown">
                                            Status
                                        </button>
                                        <ul class="dropdown-menu shadow-sm">
                                            <li><button type="submit" name="status" value="Belum Dikerjakan" class="dropdown-item small">Belum Dikerjakan</button></li>
                                            <li><button type="submit" name="status" value="Sedang Dikerjakan" class="dropdown-item small">Sedang Dikerjakan</button></li>
                                            <li><button type="submit" name="status" value="Selesai" class="dropdown-item small">Selesai</button></li>
                                        </ul>
                                    </div>
                                </form>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal" data-task-id="{{ $task->id }}" data-task-title="{{ $task->title }}" title="Hapus">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

@else
    <!-- EMPTY STATE JIKA TIDAK ADA TUGAS -->
    <div class="card shadow-sm border-0 empty-state">
        <div class="empty-icon">
            <i class="bi bi-clipboard-x"></i>
        </div>
        <h4 class="fw-bold mb-2 text-secondary">Belum Ada Tugas Ditemukan</h4>
        @if ($searchQuery || $statusFilter)
            <p class="text-muted mb-3">Tidak ada tugas yang sesuai dengan kriteria pencarian atau filter yang Anda pilih.</p>
            <div>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-azure btn-sm">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Pencarian & Filter
                </a>
            </div>
        @else
            <p class="text-muted mb-3">Mulai tambahkan tugas kuliah pertama Anda agar semua deadline terpantau dengan baik.</p>
            <div>
                <a href="{{ route('tasks.create') }}" class="btn btn-primary-azure">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Tugas Pertama
                </a>
            </div>
        @endif
    </div>
@endif

<!-- MODAL KONFIRMASI HAPUS -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-md);">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger d-flex align-items-center gap-2" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i> Konfirmasi Penghapusan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <p class="mb-2">Apakah Anda yakin ingin menghapus tugas berikut?</p>
                <div class="alert alert-light border p-3 rounded">
                    <i class="bi bi-journal-x text-danger me-2"></i>
                    <strong id="deleteTaskTitle" class="text-break">Judul Tugas</strong>
                </div>
                <small class="text-muted d-block">
                    <i class="bi bi-info-circle me-1"></i> Tindakan ini tidak dapat dibatalkan. Data tugas akan dihapus secara permanen dari database MySQL.
                </small>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <form id="deleteTaskForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger d-flex align-items-center gap-1">
                        <i class="bi bi-trash3-fill"></i> Ya, Hapus Tugas
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

