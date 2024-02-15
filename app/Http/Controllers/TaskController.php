<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function index(TodoList $todo_list)
    {
        /* $tasks = Task::Where('todo_list_id', $todo_list->id)->get();
        return $tasks; */

        $tasks = $todo_list->tasks;
        //return $tasks;
        return TaskResource::collection($tasks);
    }

    public function store(TaskRequest $request, TodoList $todo_list)
    {
        /* $request['todo_list_id'] = $todo_list->id;
        $task = Task::create($request->all());
        return $task; */
        $task = $todo_list->tasks()->create($request->validated());
        return new TaskResource($task);
    }

    public function update(Task $task, TaskRequest $request)
    {
        $task->update($request->validated());
        //return response($task);
        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }
}
