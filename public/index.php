<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Cek apakah vendor autoloader sudah terpasang
if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Setup TaskFlow Laravel</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <style>
            body { background: #f8fafc; font-family: system-ui, sans-serif; }
            .card { border-radius: 16px; border: 1px solid #e2e8f0; }
        </style>
    </head>
    <body class="d-flex align-items-center justify-content-center min-vh-100 p-3">
        <div class="card shadow-sm p-4 p-md-5" style="max-width: 650px;">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-primary text-white p-3 rounded-3 fs-3">
                    <i class="bi bi-kanban"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 text-primary">TaskFlow – Laravel Edition</h3>
                    <p class="text-muted small mb-0">Aplikasi Manajemen Tugas Mahasiswa &bull; MySQL</p>
                </div>
            </div>
            <div class="alert alert-info border-0 shadow-sm">
                <i class="bi bi-info-circle-fill me-1"></i>
                Berkas proyek Laravel telah berhasil dibuat! Untuk menjalankan aplikasi, jalankan satu langkah instalasi dependensi berikut di terminal:
            </div>
            <h6 class="fw-bold text-dark mt-3">Langkah Cepat di Terminal:</h6>
            <div class="bg-dark text-white p-3 rounded-3 font-monospace small mb-3">
                <span class="text-secondary"># 1. Masuk ke folder proyek</span><br>
                cd "/Users/lian/Documents/CRUD CloudComputing"<br><br>
                <span class="text-secondary"># 2. Unduh paket dependensi Laravel</span><br>
                composer install<br><br>
                <span class="text-secondary"># 3. Buat database dan jalankan migrasi data</span><br>
                php artisan migrate --seed<br><br>
                <span class="text-secondary"># 4. Jalankan server lokal</span><br>
                php artisan serve
            </div>
            <p class="text-muted small mb-0">
                <i class="bi bi-check2-circle text-success me-1"></i> Database SQL juga telah disediakan di berkas <code>database/taskflow.sql</code> untuk import langsung lewat <strong>phpMyAdmin</strong>.
            </p>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Cek maintenance mode
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Muat Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel dan tangani request
$app = require_once __DIR__.'/../bootstrap/app.php';

if ($app instanceof \Illuminate\Foundation\Application) {
    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Request::capture()
    );
    $response->send();
    $kernel->terminate($request, $response);
} else {
    $app->handleRequest(Request::capture());
}

