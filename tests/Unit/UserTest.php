<?php

namespace Tests\Unit;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_has_many_todo_list()
    {
        $user = $this->createUser();
        $list = $this->createTodo(['user_id' => $user->id]);
        $this->assertInstanceOf(TodoList::class, $user->todo_lists->first());
    }
}
