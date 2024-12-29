<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\MasterJob;

class JobSkills extends Model
{
    protected $table = 'job_skills';

    protected $fillable = [
        'job_id',
        'job_skill_id',
        'proficiency_level', // Example additional column
    ];

    public $timestamps = true;
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function job()
    {
        return $this->belongsTo(MasterJob::class, 'job_id');
    }

    // Relationship to MasterSkill
    public function skill()
    {
        return $this->belongsTo(MasterSkill::class, 'job_skill_id');
    }
}
