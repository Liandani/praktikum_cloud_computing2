<?php

namespace Database\Seeders;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = Carbon::today();

        $sampleTasks = [
            [
                'title' => 'Implementasi Web Service & CRUD di Azure',
                'course' => 'Cloud Computing',
                'deadline' => $today->copy()->addDays(5),
                'status' => 'Sedang Dikerjakan',
                'description' => 'Membangun aplikasi Laravel dan menghubungkan ke database MySQL serta konfigurasi Azure App Service.',
            ],
            [
                'title' => 'Latihan Model Klasifikasi CNN',
                'course' => 'Kecerdasan Buatan',
                'deadline' => $today->copy()->addDays(12),
                'status' => 'Belum Dikerjakan',
                'description' => 'Melakukan fine-tuning model ResNet-50 pada dataset gambar CIFAR-10.',
            ],
            [
                'title' => 'Review Jurnal Sistem Terdistribusi',
                'course' => 'Sistem Terdistribusi',
                'deadline' => $today->copy()->subDays(2),
                'status' => 'Belum Dikerjakan',
                'description' => 'Membuat ringkasan 3 halaman mengenai mekanisme konsensus Raft dan Paxos.',
            ],
            [
                'title' => 'Praktikum 1: Setup Lingkungan Docker & Git',
                'course' => 'DevOps & Cloud',
                'deadline' => $today->copy()->subDays(7),
                'status' => 'Selesai',
                'description' => 'Konfigurasi Dockerfile dan push repositori tugas ke GitHub Classroom.',
            ],
            [
                'title' => 'Perancangan Skema Basis Data Normalisasi 3NF',
                'course' => 'Basis Data Lanjut',
                'deadline' => $today->copy()->addDays(20),
                'status' => 'Belum Dikerjakan',
                'description' => 'Membuat Entity Relationship Diagram (ERD) dan skema relasional tabel tugas.',
            ],
        ];

        foreach ($sampleTasks as $taskData) {
            Task::create($taskData);
        }
    }
}

