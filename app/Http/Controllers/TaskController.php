<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return response()->json(Task::latest()->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $task = Task::create([
            'title' => $request->title
        ]);

        return response()->json([
            'message' => 'Task added successfully',
            'task' => $task
        ]);
    }

    public function toggle($id)
    {
        $task = Task::findOrFail($id);
        $task->is_done = !$task->is_done;
        $task->save();

        return response()->json([
            'message' => 'Task updated',
            'task' => $task
        ]);
    }
}