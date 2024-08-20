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

    public function projectTasks(){
        return $this->hasMany(Task::class);
    }

    public function updateTaskCount(){
        $this->tasks = $this->projectTasks()->count();
        $this -> save();
    }

    public function updateProgress(){
        $compleatedTasks = $this->projectTasks()->where('status',true)->count();
        $totalTasks = $this->projectTasks()->count();
        if($totalTasks === 0)
            $this->progresss = 100;
        else
            $this->progress = ($compleatedTasks/$totalTasks)*100;
        $this->save();

    }
}
