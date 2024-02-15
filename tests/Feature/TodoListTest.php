<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Database\Factories\TodoListFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase; //refresh your migration
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private $todolist;

    public function setUp(): void
    {
        parent::setUp();
        $user = $this->authUser();
        $this->todolist = $this->createTodo(['name' => 'my list', 'user_id' => $user->id]);
    }

    public function test_fetch_all_todo_list()
    {

        //TodoList::create(['name' => 'Name 1']);
        //$this->getJson('todo-list') //sends get request
        //$response->Json() //converts json to array

        /* $response = $this->get('/');

        $response->assertStatus(200); */

        // Preparation //prepare

        //TodoList::factory()->create(); //create single record


        // TodoList::factory()->count(20)->create(); //create 20 records

        // TodoList::factory()->count(20)->create(['name'=>'mylist']); //create 20 records and over write facker values for name column

        //TodoList::factory()->create(['name' => 'my list']); //create single record and over write facker values for name column

        // action //perform

        $this->createTodo();

        $response = $this->getJson(route('todo-list.index'))->Json('data');

        //dd($response->Json());
        // assertion //predict



        $this->assertEquals(1, count($response));
        $this->assertEquals('my list', $response[0]['name']);
    }

    public function test_fetch_single_todo_list()
    {
        //$todo = TodoList::factory()->create();
        //$response = $this->getJson(route('todo-list.show', $todo->id));
        //$response->assertStatus(200); // check response status code
        //$response->assertOk(); // check response status code
        //$response->Json(); // encode json response to array

        $response = $this->getJson(route('todo-list.show', $this->todolist->id))->assertOk()->Json('data');
        $this->assertEquals($response['name'], $this->todolist->name);
    }

    public function test_store_new_todo_list()
    {
        $newList = TodoList::factory()->make(['name' => 'my created to list']); // TodoList::factory()->make(['name' => 'my created to list']); doesnt create record in the database
        $response = $this->postJson(route('todo-list.store', ['name' => $newList->name]))->assertCreated()->Json('data');
        $this->assertEquals($newList->name, $response['name']);
        $this->assertDatabaseHas('todo_lists', ['name' => $newList->name]); // $this->assertDatabaseHas('table name', 'array to be compare');
    }

    public function test_while_storing_todo_list_name_field_is_required()
    {
        $this->withExceptionHandling();
        $response = $this->postJson(route('todo-list.store'))
            ->assertUnprocessable() //assertUnprocessable() is equal to assertStatus(422);
            ->assertJsonValidationErrors(['name']); //assertJsonValidationErrors() check for validation
    }

    public function test_delete_todo_list()
    {
        $this->deleteJson(route('todo-list.destroy', $this->todolist->id))
            ->assertNoContent();
        $this->assertDatabaseMissing('todo_lists', ['name' => $this->todolist->name]);
    }

    public function test_update_todolist()
    {
        $this->patchJson(route('todo-list.update', $this->todolist->id), ['name' => 'update name'])->assertOk();
        $this->assertDatabaseHas('todo_lists', ['id' => $this->todolist->id, 'name' => 'update name']);
    }

    public function test_while_updating_todo_list_name_field_is_required()
    {
        $this->withExceptionHandling();
        $response = $this->patchJson(route('todo-list.update', $this->todolist->id))
            ->assertUnprocessable() //assertUnprocessable() is equal to assertStatus(422);
            ->assertJsonValidationErrors(['name']); //assertJsonValidationErrors() check for validation
    }
}
