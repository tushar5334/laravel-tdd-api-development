<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoListRequest;
use App\Http\Resources\TodoResource;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{
    //

    public function index()
    {
        //$todoLists = TodoList::where('user_id', auth()->id())->get();
        $todoLists = auth()->user()->todo_lists;
        //return response($todoLists);
        return TodoResource::collection($todoLists);
    }

    public function show(TodoList $todo_list)
    {
        //$todolist = TodoList::find($id);
        //$todolist = TodoList::findOrFail($id);
        //return response($todo_list);
        return new TodoResource($todo_list);
    }

    public function store(TodoListRequest $request)
    {
        //$newTodo = TodoList::create($request->all());
        //Three ways to return response with status code 201//
        //return response($newTodo, Response::HTTP_CREATED); 
        //return response($newTodo, 201);
        //return $newTodo;
        //return TodoList::create($request->all());
        //return auth()->user()->todo_lists()->create($request->validated());
        $todo_list = auth()->user()->todo_lists()->create($request->validated());
        return new TodoResource($todo_list);
    }


    public function destroy(TodoList $todo_list)
    {
        //$todo_list->tasks->each->delete(); // delete todos related task using code
        $todo_list->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    public function update(TodoListRequest $request, TodoList $todo_list)
    {
        $todo_list->update($request->all());
        //return response($todo_list);
        return new TodoResource($todo_list);
    }
}
