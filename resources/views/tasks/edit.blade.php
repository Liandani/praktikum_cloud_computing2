@extends('layouts.app')

@section('title', 'Edit Tugas: ' . $task->title . ' – TaskFlow Laravel')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">

        <!-- BREADCRUMB -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item">
                    <a href="{{ route('tasks.index') }}" class="text-decoration-none">
                        <i class="bi bi-house-door me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Tugas</li>
            </ol>
        </nav>

        <!-- FORM CARD -->
        <div class="form-card">
            <!-- Header Form -->
            <div class="d-flex align-items-center gap-3 pb-3 mb-4 border-bottom">
                <div class="stat-icon in-progress">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div>
                    <h3 class="h4 fw-bold mb-0" style="color: var(--primary-navy);">Edit Data Tugas</h3>
                    <p class="text-muted small mb-0">
                        Perbarui detail tugas atau ubah status perkembangannya di MySQL.
                    </p>
                </div>
            </div>

            <!-- Formulir Input -->
            <form method="POST" action="{{ route('tasks.update', $task) }}">
                @csrf
                @method('PUT')
                
                <!-- Judul Tugas -->
                <div class="mb-3">
                    <label for="title" class="form-label">
                        Judul Tugas <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0">
                            <i class="bi bi-card-heading"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-1 @error('title') is-invalid @enderror" id="title" name="title" required placeholder="Contoh: Implementasi Web Service & CRUD Laravel" value="{{ old('title', $task->title) }}">
                    </div>
                    @error('title')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @else
                        <div class="form-text small">Tuliskan nama tugas dengan ringkas dan jelas.</div>
                    @enderror
                </div>

                <div class="row g-3 mb-3">
                    <!-- Mata Kuliah -->
                    <div class="col-12 col-md-6">
                        <label for="course" class="form-label">Mata Kuliah</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0">
                                <i class="bi bi-book"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-1 @error('course') is-invalid @enderror" id="course" name="course" placeholder="Contoh: Cloud Computing" value="{{ old('course', $task->course) }}">
                        </div>
                        @error('course')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deadline -->
                    <div class="col-12 col-md-6">
                        <label for="deadline" class="form-label">Batas Waktu (Deadline)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0">
                                <i class="bi bi-calendar3"></i>
                            </span>
                            <input type="date" class="form-control border-start-0 ps-1 @error('deadline') is-invalid @enderror" id="deadline" name="deadline" value="{{ old('deadline', $task->deadline ? $task->deadline->format('Y-m-d') : '') }}">
                        </div>
                        @error('deadline')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Status Pengerjaan -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status Pengerjaan</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0">
                            <i class="bi bi-flag"></i>
                        </span>
                        <select class="form-select border-start-0 ps-1 @error('status') is-invalid @enderror" id="status" name="status">
                            @foreach (\App\Models\Task::VALID_STATUSES as $st)
                                <option value="{{ $st }}" {{ old('status', $task->status) === $st ? 'selected' : '' }}>
                                    {{ $st }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('status')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Deskripsi Tugas -->
                <div class="mb-4">
                    <label for="description" class="form-label">Deskripsi / Catatan Tambahan</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Tuliskan detail instruksi tugas, kriteria penilaian, link repository, dsb...">{{ old('description', $task->description) }}</textarea>
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end align-items-center gap-2 pt-2 border-top">
                    <a href="{{ route('tasks.index') }}" class="btn btn-light px-4">
                        <i class="bi bi-arrow-left me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary-azure px-4 d-flex align-items-center gap-2">
                        <i class="bi bi-check-lg"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection

