<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Events\TaskUpdated;
use App\Models\User;
use App\Models\Assignments;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','description','priority','deadline','status','project_id','status'
    ];

    protected $dispatchesEvents =[
        'saved' => TaskUpdated::class,
        'created' => TaskUpdated::class,
        'updated' => TaskUpdated::class,
        'deleted' => TaskUpdated::class,
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function setStatue($status){
        $this->status = $status;
        $this->save();
    }

        // Define a scope to filter by status
        public function scopeByStatus($query, $status)
        {
            return $query->where('status', $status);
        }
    
        // Define a scope to filter by priority
        public function scopeByPriority($query, $priority)
        {
            return $query->where('priority', $priority);
        }
    
        // Define a scope to filter by deadline
        public function scopeByDeadline($query, $deadline)
        {
            return $query->where('deadline', '<=', $deadline);
        }

        public function scopeByProjectId($query, $projectId)
        {
            return $query->where('project_id', $projectId);
        }
    

        public function users()
        {
            return $this->belongsToMany(User::class, 'assignments');
        }

}
