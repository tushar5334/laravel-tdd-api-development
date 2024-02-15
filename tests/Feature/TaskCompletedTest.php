<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskCompletedTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_task_status()
    {
        $this->authUser();
        $task = $this->createTask();
        $response = $this->patchJson(route('task.update', $task->id), ['title' => $task->title, 'status' => Task::TASK_STARTED])->json();
        $this->assertDatabaseHas('tasks', ['status' => Task::TASK_STARTED]);
    }
}
