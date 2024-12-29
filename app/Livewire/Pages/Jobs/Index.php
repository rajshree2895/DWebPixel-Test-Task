<?php

namespace App\Livewire\Pages\Jobs;

use Livewire\Component;
use App\Models\MasterJob;

class Index extends Component
{
    public $showConfirmDeleteModal = false;
    public $jobToDeleteId = null;

    // Use a collection instead of an array for jobList
    public $jobList;

    public function mount()
    {
        $this->retrieveJobs();
    }

    public function promptDelete($jobId)
    {
        $this->jobToDeleteId = $jobId;
        $this->showConfirmDeleteModal = true;
    }

    public function performDelete()
    {
        if ($this->jobToDeleteId) {
            $job = MasterJob::find($this->jobToDeleteId);

            if ($job) {
                $job->delete();
                $this->retrieveJobs(); // Refresh job list after deletion
                session()->flash('message', 'Job successfully removed.');
            } else {
                session()->flash('error', 'Job not found.');
            }
        }

        $this->showConfirmDeleteModal = false;
    }

    public function closeModal()
    {
        $this->showConfirmDeleteModal = false;
    }

    public function retrieveJobs()
    {
        // Use Eloquent collection for better data handling
        $this->jobList = MasterJob::with('skills')->get();
    }

    public function render()
    {
        // Pass jobList directly to the view
        return view('livewire.pages.jobs.manage-jobs', [
            'jobList' => $this->jobList,
        ]);
    }
}
