<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return $user;
        } catch (ModelNotFoundException $e){
            return $this->errorResponse("invalid input",404,"user not found");
        }
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, Request $request)
    {
        try {
            $permission = $request -> permission;
            $user = User::findOrFail($id);
            switch ($permission){
                case 1:
                    //assign user role
                    $user->syncRoles('user'); 
                    break;
                case 2:
                    //assign user role
                    $user->syncRoles('editor'); 
                    break;
            }
            return $user;
        } catch (ModelNotFoundException $e){
            return $this->errorResponse("invalid input",404,"useer not found");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = Task::findOrFail($id);
            $user->delete();
            return 'user deleted successfully';
        }catch (ModelNotFoundException $e){
            return $this->errorResponse("invalid input",404,"user not found");
        }
    }
}
