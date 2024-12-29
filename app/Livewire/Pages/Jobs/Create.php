<?php

namespace App\Livewire\Pages\Jobs;

use Livewire\Component;
use App\Models\MasterSkill;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use App\Models\MasterJob;

class Create extends Component
{
    use WithFileUploads;

    public $jobTitle, $jobDescription, $jobExperience, $jobSalary, $jobLocation, $jobExtraInfo;
    public $companyName, $companyLogo, $selectedSkills = [];

    public function saveJob()
    {
        $this->validate([
            'jobTitle' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s,.-]+$/',
            'jobDescription' => 'required|string|regex:/^[a-zA-Z0-9\s,&.\-\/]+$/',
            'jobExperience' => 'required|string|regex:/^[a-zA-Z0-9\s,.-]+$/',
            'jobSalary' => 'required|string|regex:/^[a-zA-Z0-9\s,.-]+$/',
            'jobLocation' => 'required|string|regex:/^[a-zA-Z0-9\s,.-]+$/',
            'jobExtraInfo' => 'required|string|regex:/^[a-zA-Z0-9\s,.-]*$/',
            'companyName' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s.,-]+$/',
            'companyLogo' => 'required|image|max:2048',
            'selectedSkills' => 'required|array',
            'selectedSkills.*' => 'exists:master_skills,id', // Ensuring the selected skills exist
        ]);

        // Handle company logo file upload
        if ($this->companyLogo) {
            $logoPath = $this->companyLogo->store('company_logos', 'public');
        }

        // Store the job posting
        $job = MasterJob::create([
            'job_title' => $this->jobTitle,
            'job_description' => $this->jobDescription,
            'job_experience' => $this->jobExperience,
            'job_salary' => $this->jobSalary,
            'job_location' => $this->jobLocation,
            'job_extra_info' => $this->jobExtraInfo,
            'job_company_name' => $this->companyName,
            'job_company_logo' => $logoPath ?? null,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        // Attach selected skills to the job
        $job->skills()->sync($this->selectedSkills);

        session()->flash('message', 'Job created successfully.');

        // Reset form fields
        $this->resetFields();
    }

    public function fetchSkills()
    {
        return MasterSkill::all();
    }

    public function resetFields()
    {
        $this->jobTitle = '';
        $this->jobDescription = '';
        $this->jobExperience = '';
        $this->jobSalary = '';
        $this->jobLocation = '';
        $this->jobExtraInfo = '';
        $this->companyName = '';
        $this->companyLogo = null;
        $this->selectedSkills = [];
    }

    public function render()
    {
        return view('livewire.pages.jobs.create', [
            'skills' => $this->fetchSkills()
        ]);
    }
}
