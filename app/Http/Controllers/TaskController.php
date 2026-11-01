<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Menampilkan Dashboard Daftar Tugas dan Statistik (Read).
     */
    public function index(Request $request)
    {
        $searchQuery = trim($request->input('q', ''));
        $statusFilter = trim($request->input('status', ''));
        $sortBy = $request->input('sort', 'deadline');

        $query = Task::query();

        // Filter Pencarian (Judul, Mata Kuliah, Deskripsi)
        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'LIKE', "%{$searchQuery}%")
                  ->orWhere('course', 'LIKE', "%{$searchQuery}%")
                  ->orWhere('description', 'LIKE', "%{$searchQuery}%");
            });
        }

        // Filter Status
        if (!empty($statusFilter) && in_array($statusFilter, Task::VALID_STATUSES)) {
            $query->where('status', $statusFilter);
        }

        // Pengurutan Data
        switch ($sortBy) {
            case 'created_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'deadline_desc':
                // Null deadline diletakkan di akhir
                $query->orderByRaw('deadline IS NULL, deadline DESC');
                break;
            default: // deadline terdekat (null di akhir)
                $query->orderByRaw('deadline IS NULL, deadline ASC, created_at DESC');
                break;
        }

        $tasks = $query->get();

        // Hitung Statistik
        $total = Task::count();
        $completed = Task::where('status', Task::STATUS_COMPLETED)->count();
        $inProgress = Task::where('status', Task::STATUS_PROGRESS)->count();
        $pending = Task::where('status', Task::STATUS_PENDING)->count();
        $overdue = Task::whereNotNull('deadline')
            ->where('deadline', '<', Carbon::today())
            ->where('status', '!=', Task::STATUS_COMPLETED)
            ->count();

        $completionRate = $total > 0 ? (int) round(($completed / $total) * 100) : 0;

        $stats = [
            'total' => $total,
            'completed' => $completed,
            'in_progress' => $inProgress,
            'pending' => $pending,
            'overdue' => $overdue,
            'completion_rate' => $completionRate,
        ];

        return view('tasks.index', compact('tasks', 'stats', 'searchQuery', 'statusFilter', 'sortBy'));
    }

    /**
     * Menampilkan Form Tambah Tugas Baru (Create View).
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Menyimpan Tugas Baru ke Database (Create Store).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'course' => 'nullable|string|max:100',
            'deadline' => 'nullable|date',
            'status' => 'required|in:' . implode(',', Task::VALID_STATUSES),
            'description' => 'nullable|string',
        ]);

        $task = Task::create($validated);

        return redirect()->route('tasks.index')
            ->with('success', "Tugas \"{$task->title}\" berhasil ditambahkan!");
    }

    /**
     * Menampilkan Form Edit Tugas (Update View).
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Memperbarui Data Tugas di Database (Update Store).
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'course' => 'nullable|string|max:100',
            'deadline' => 'nullable|date',
            'status' => 'required|in:' . implode(',', Task::VALID_STATUSES),
            'description' => 'nullable|string',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', "Tugas \"{$task->title}\" berhasil diperbarui!");
    }

    /**
     * Update Cepat Status Tugas dari Dropdown Tabel/Kartu.
     */
    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', Task::VALID_STATUSES),
        ]);

        $task->update([
            'status' => $request->input('status'),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'task' => $task,
            ]);
        }

        return redirect()->back()
            ->with('info', "Status tugas \"{$task->title}\" diubah menjadi \"{$task->status}\"!");
    }

    /**
     * Menghapus Tugas dari Database (Delete).
     */
    public function destroy(Task $task)
    {
        $title = $task->title;
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('warning', "Tugas \"{$title}\" berhasil dihapus!");
    }

    /**
     * Endpoint Health Check untuk Azure App Service / Monitoring.
     */
    public function health()
    {
        $dbStatus = 'unknown';
        $statusCode = 200;

        try {
            DB::connection()->getPdo();
            $dbStatus = 'connected';
        } catch (\Exception $e) {
            $dbStatus = 'error: ' . $e->getMessage();
            $statusCode = 500;
        }

        return response()->json([
            'status' => $statusCode === 200 ? 'healthy' : 'unhealthy',
            'application' => 'TaskFlow – Laravel Edition',
            'framework' => 'Laravel ' . app()->version(),
            'database' => [
                'status' => $dbStatus,
                'driver' => config('database.default'),
            ],
            'timestamp' => Carbon::now()->toIso8601String(),
        ], $statusCode);
    }
}

