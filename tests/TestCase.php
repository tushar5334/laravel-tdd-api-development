<?php

namespace Tests;

use App\Models\Lable;
use App\Models\Service;
use App\Models\Task;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function createTodo(array $args = []): object
    {
        return TodoList::factory()->create($args);
    }

    public function createTask(array $args = []): object
    {
        return Task::factory()->create($args);
    }

    public function createUser(array $args = []): object
    {
        return User::factory()->create($args);
    }
    public function authUser()
    {
        $user = $this->createUser();
        Sanctum::actingAs($user);
        return $user;
    }
    public function createLable(array $args = []): object
    {
        return Lable::factory()->create($args);
    }

    public function createService(array $args = []): object
    {
        return Service::factory()->create($args);
    }
}
