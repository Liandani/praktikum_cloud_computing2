@extends('layouts.app')

@section('title', '500 Kesalahan Server – TaskFlow')

@section('content')
<div class="row justify-content-center my-5">
    <div class="col-12 col-md-8 col-lg-6 text-center">
        <div class="p-5 bg-white rounded-4 shadow-sm border">
            <div class="display-1 fw-bold text-danger mb-3">500</div>
            <h3 class="fw-bold mb-2" style="color: var(--primary-navy);">Terjadi Kesalahan Server / Database</h3>
            <p class="text-muted mb-4">
                Sistem tidak dapat terhubung ke database MySQL. Pastikan MySQL di XAMPP / server lokal sudah aktif dan kredensial di file <code>.env</code> sudah sesuai.
            </p>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-house-door me-1"></i> Dashboard
                </a>
                <a href="{{ route('health') }}" class="btn btn-primary-azure">
                    <i class="bi bi-heart-pulse me-1"></i> Cek Health Endpoint
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

