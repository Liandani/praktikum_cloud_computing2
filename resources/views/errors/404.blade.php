@extends('layouts.app')

@section('title', '404 Halaman Tidak Ditemukan – TaskFlow')

@section('content')
<div class="row justify-content-center my-5">
    <div class="col-12 col-md-8 col-lg-6 text-center">
        <div class="p-5 bg-white rounded-4 shadow-sm border">
            <div class="display-1 fw-bold text-primary mb-3">404</div>
            <h3 class="fw-bold mb-2" style="color: var(--primary-navy);">Halaman Tidak Ditemukan</h3>
            <p class="text-muted mb-4">
                Maaf, data tugas atau halaman yang Anda cari tidak tersedia di database.
            </p>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('tasks.index') }}" class="btn btn-primary-azure">
                    <i class="bi bi-house-door me-1"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

