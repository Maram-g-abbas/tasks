<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAssignmentsRequest;
use App\Http\Requests\UpdateAssignmentsRequest;
use App\Models\Assignments;
use App\Models\User;
use App\Models\Task;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AssignmentsController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Assignments::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssignmentsRequest $request)
    {
        $fields = $request->validated();
        $user = User::find($fields["user_id"]);
        $task = Task::find($fields["task_id"]);
        $user->tasks()->attach($task);
        return $user->tasks;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return $user->tasks;
        }catch (ModelNotFoundException $e){
            return $this->errorResponse("invalid input",404,"user not found");
        }
    }
  

    public function getAssingments(Request $request){
        $user = $request->user();
        return $user->tasks;
    }
}
