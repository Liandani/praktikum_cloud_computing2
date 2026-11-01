<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'course',
        'deadline',
        'status',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public const STATUS_PENDING = 'Belum Dikerjakan';
    public const STATUS_PROGRESS = 'Sedang Dikerjakan';
    public const STATUS_COMPLETED = 'Selesai';

    public const VALID_STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_PROGRESS,
        self::STATUS_COMPLETED,
    ];

    /**
     * Mengecek apakah deadline tugas sudah terlewat dan tugas belum selesai.
     */
    public function getIsOverdueAttribute(): bool
    {
        if ($this->deadline && $this->status !== self::STATUS_COMPLETED) {
            return $this->deadline->isPast() && !$this->deadline->isToday();
        }
        return false;
    }

    /**
     * Kelas CSS badge custom modern.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PROGRESS => 'badge-status-progress',
            self::STATUS_COMPLETED => 'badge-status-completed',
            default => 'badge-status-pending',
        };
    }

    /**
     * Format tanggal deadline Indonesia (misal: 15 Nov 2024).
     */
    public function getFormattedDeadlineAttribute(): ?string
    {
        return $this->deadline ? $this->deadline->format('d M Y') : null;
    }
}

