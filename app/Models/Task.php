<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'todo_list_id', 'description', 'status', 'lable_id'];
    public const TASK_NOT_STARTED = 'task_not_started';
    public const TASK_STARTED = 'started';
    public const TASK_PENDING = 'pending';
    public const TASK_COMPLETED = 'completed';

    public function todo_list(): BelongsTo
    {
        return $this->belongsTo(TodoList::class);
    }

    public function lable(): BelongsTo
    {
        return $this->belongsTo(Lable::class);
    }
}
