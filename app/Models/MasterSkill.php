<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterJob;

class MasterSkill extends Model
{
    protected $fillable = [
        'skill_name',
        'created_by',
        'updated_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function jobs()
    {
        return $this->belongsToMany(MasterJob::class, 'job_skills', 'job_id', 'job_skill_id');
    }
}
