<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Project extends Model
{
    use HasFactory;

    protected $fillable =[
        'name','description','tasks','progress'
    ];

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    // public function updateTaskCount(){
    //     $this->tasks = $this->tasks()->count();
    //     $this -> save();
    // }

    public function updateProgress(){
        $compleatedTasks = $this->tasks->where('status',true)->count();
        $totalTasks = $this->tasks()->count();
        if($totalTasks === 0)
            $this->progresss = 100;
        else
            $this->progress = ($compleatedTasks/$totalTasks)*100;
        $this->save();

    }
}
