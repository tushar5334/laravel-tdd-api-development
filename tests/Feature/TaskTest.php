<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase; //refresh your migration
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private $task;
    public function setUp(): void
    {
        parent::setUp();
        $this->authUser();
        $this->todolist = $this->createTodo();
        $this->lable = $this->createLable(['user_id' => auth()->id()]);
        $this->task = $this->createTask(['todo_list_id' => $this->todolist->id, 'lable_id' => $this->lable->id, 'lable_id' => $this->lable->id]);
        $todolist2 = $this->createTodo();
        $this->createTask(['todo_list_id' => $todolist2->id]);
    }

    public function test_fetch_all_task_of_a_todo_list()
    {
        $response = $this->getJson(route('todo-list.task.index', $this->todolist->id))->assertOk()->json('data');
        $this->assertEquals(1, count($response));
        $this->assertEquals($this->task->title, $response[0]['title']);
        //$this->assertEquals($this->task->todo_list_id, $response[0]['todo_list_id']);
    }

    public function test_create_a_task_of_a_todo_list()
    {
        $task = Task::factory()->make();
        $response = $this->postJson(route('todo-list.task.store', $this->todolist->id), ['title' => $task->title, 'todo_list_id' => $this->todolist->id, 'lable_id' => $this->lable->id])->assertCreated()->json();
        $this->assertDatabaseHas('tasks', ['title' => $task->title, 'todo_list_id' => $this->todolist->id]);
    }
    public function test_create_a_task_without_lable_of_a_todo_list()
    {
        $task = Task::factory()->make();
        $response = $this->postJson(route('todo-list.task.store', $this->todolist->id), ['title' => $task->title, 'todo_list_id' => $this->todolist->id])->assertCreated()->json();
        $this->assertDatabaseHas('tasks', ['title' => $task->title, 'todo_list_id' => $this->todolist->id]);
    }
    public function test_delete_a_task()
    {
        $this->deleteJson(route('task.destroy', $this->task->id))->assertNoContent();
    }

    public function test_update_a_task_of_a_todo_list()
    {
        $response = $this->patchJson(route('task.update', $this->task->id), ['title' => 'updated task'])->assertOk()->json();
        $this->assertDatabaseHas('tasks', ['title' => 'updated task']);
    }
}
