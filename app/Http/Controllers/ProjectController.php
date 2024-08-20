<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectController extends Controller
{
    use APIResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            return Project::all();
       
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        
        $fields = $request->validated();
        $project = Project::create($fields);
        if(!$project)
            return $this->errorResponse("error creating project");
        return $project;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $project = Project::findOrFail($id);
            return $project;
        }catch (ModelNotFoundException $e){
            return $this->errorResponse("invalid input",404,"project not found");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request,$id)
    {
            $fields = $request->validated();
        try {
            $project = Project::findOrFail($id);
            $project->update($fields);
            return $project;
        } catch (ModelNotFoundException $e){
            return $this->errorResponse("invalid input",404,"project not found");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();
            return 'project deleted successfully';
        } catch (ModelNotFoundException $e){
            return $this->errorResponse("invalid input",404,"project not found");
        }
    }
}
