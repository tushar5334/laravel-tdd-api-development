<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_todo_list_can_has_many_tasks()
    {
        $list = $this->createTodo();
        $task = $this->createTask(['todo_list_id' => $list->id]);

        $this->assertInstanceOf(Collection::class, $list->tasks);
        $this->assertInstanceOf(Task::class, $list->tasks->first());
    }

    public function test_if_todo_list_is_deleted_then_delete_related_tasks()
    {
        $list = $this->createTodo();
        $task = $this->createTask(['todo_list_id' => $list->id]);
        $task2 = $this->createTask();

        /* $list->delete();
        $list->tasks->each->delete(); */

        $list->delete();

        $this->assertDatabaseMissing('todo_lists', ['id' => $list->id]);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
        $this->assertDatabaseHas('tasks', ['id' => $task2->id]);
    }
}
