<?php

namespace App\Livewire\Pages\Skills;

use Livewire\Component;
use App\Models\MasterSkill;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $skillName, $allSkills, $currentSkillId, $isDeleteModalVisible = false;

    protected $rules = [
        'skillName' => 'required|string|max:255|unique:master_skills,skill_name',
    ];

    public function mount()
    {
        $this->loadSkills();
    }

    public function saveSkill()
    {
        try {
            $this->validate([
                'skillName' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]+$/|unique:master_skills,skill_name',
            ]);

            if ($this->currentSkillId) {
                $skill = MasterSkill::findOrFail($this->currentSkillId);
                $skill->update(['skill_name' => $this->skillName]);
                $this->handleToast('message','Skill updated successfully');
                $this->skillName = '';
            } else {
                MasterSkill::create(['skill_name' => $this->skillName, 'created_by' => Auth::id(), 'updated_by' => Auth::id()]);
                $this->handleToast('message','Skill created successfully');
                $this->skillName = '';
            }

            $this->loadSkills();
            $this->resetFields();
        } catch (\Exception $e) {
            $this->handleToast('error', $e->getMessage());
        }
    }


    public function editSkill($id)
    {
        $skill = MasterSkill::findOrFail($id);
        $this->currentSkillId = $skill->id;
        $this->skillName = $skill->skill_name;
    }

    public function confirmSkillDeletion($id)
    {
        $this->currentSkillId = $id;
        $this->isDeleteModalVisible = true;
    }

    public function deleteSkill()
    {
        try {
            $skill = MasterSkill::findOrFail($this->currentSkillId);
            $isLinkedToJob = $skill->jobs()->exists();

            if ($isLinkedToJob) {
                $this->closeDeleteModal();
                throw new \Exception('Skill is associated with job postings. Please remove the association first.');
            } else {
                $skill->delete();
                $this->loadSkills();
                $this->closeDeleteModal();
                $this->handleToast('message', 'Skill deleted successfully');
            }
        } catch (\Exception $e) {
            $this->handleToast('error', $e->getMessage());
        }
    }

    public function closeDeleteModal()
    {
        $this->resetFields();
        $this->isDeleteModalVisible = false;
    }

    public function resetFields()
    {
        $this->skillName = '';
        $this->currentSkillId = null;
        $this->isDeleteModalVisible = false;
    }

    public function loadSkills()
    {
        $this->allSkills = MasterSkill::all();
    }

    public function handleToast($type = 'message', $message)
    {
        session()->flash($type, $message);
    }

    public function render()
    {
        return view('livewire.pages.skills.manage', ['allSkills' => $this->allSkills]);
    }
}
