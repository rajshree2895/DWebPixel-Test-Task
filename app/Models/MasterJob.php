<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterJob extends Model
{
    protected $table = 'master_jobs';
    protected $fillable = [
        'job_title',
        'job_description',
        'job_experience',
        'job_salary',
        'job_location',
        'job_extra_info',
        'job_company_name',
        'job_company_logo',
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

    public function skills()
    {
        return $this->belongsToMany(MasterSkill::class, 'job_skills', 'job_id', 'job_skill_id');
    }
}
