<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use  App\Notifications\TaskDeadline;

class TaskController extends Controller
{
    use APIResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::query()->with(['users' => function ($query) {
            $query->select('user_id', 'name');
        }]);

        // Apply status filter if provided
        if ($request->has('status')) {
            $query->byStatus($request->status);
        }

        // Apply priority filter if provided
        if ($request->has('priority')) {
            $query->byPriority($request->priority);
        }

        // Apply deadline filter if provided
        if ($request->has('deadline')) {
            $query->byDeadline($request->deadline);
        }

        // Apply deadline filter if provided
        if ($request->has('project_id')) {
            $projectId = $request->input('project_id');
            $query->byProjectId($projectId);
        }



        // Get the filtered tasks
        $tasks = $query->get();
        return response()->json($tasks);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $fields = $request->validated();
        $task = Task::create($fields);
        return $task;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $task = Task::findOrFail($id)->with(['users' => function ($query) {
                $query->select('user_id', 'name');
            }]);
            return $task;
        } catch (ModelNotFoundException $e){
            return $this->errorResponse("invalid input",404,"task not found");
        }
        
    }

    /**
     * Update the specified resource in storage.
     **/
    public function update(UpdateTaskRequest $request,$id)
    {
        $fields = $request->validated();
        try {
            $task = Task::findOrFail($id);
            $task->update($fields);
            return $task;
        }catch (ModelNotFoundException $e){
            return $this->errorResponse("invalid input",404,"task not found");
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            return 'task deleted successfully';
        }catch (ModelNotFoundException $e){
            return $this->errorResponse("invalid input",404,"task not found");
        }
    }

    public function updateStatus(UpdateTaskStatusRequest $request,$id){
        $request->validated();
        try {
            $task = Task::findOrFail($id);
            $task->setStatue($request->status);
            return $task;
        }catch (ModelNotFoundException $e){
            return $this->errorResponse("invalid input",404,"task not found");
        }
    }

    public function notify(Request $request){
        $user = $request->user();
        
        try {
            $user->notify(new TaskDeadline());
            return 'email sent successfull';
        } catch (\Exception $e) {
            // Handle the notification error here
            return $e->getMessage();
        }    
    }

}