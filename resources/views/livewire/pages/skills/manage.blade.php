<div class="container mx-auto py-6 px-4">
    <!-- Flash Messages -->
    <div 
        x-data="{ showMessage: false }" 
        x-init="$watch('showMessage', value => { if (value) setTimeout(() => showMessage = false, 3000); })"
        class="fixed top-4 right-4 z-50 w-full max-w-sm"
    >
        @if(session()->has('message'))
            <div 
                class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg mb-4 transition-all duration-500 ease-in-out transform"
                x-show="showMessage"
                x-init="showMessage = true"
                x-transition:enter="transform ease-out duration-300"
                x-transition:enter-start="translate-y-2 opacity-0"
                x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transform ease-in duration-300"
                x-transition:leave-start="translate-y-0 opacity-100"
                x-transition:leave-end="translate-y-2 opacity-0"
            >
                {{ session('message') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div 
                class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg mb-4 transition-all duration-500 ease-in-out transform"
                x-show="showMessage"
                x-init="showMessage = true"
                x-transition:enter="transform ease-out duration-300"
                x-transition:enter-start="translate-y-2 opacity-0"
                x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transform ease-in duration-300"
                x-transition:leave-start="translate-y-0 opacity-100"
                x-transition:leave-end="translate-y-2 opacity-0"
            >
                {{ session('error') }}
            </div>
        @endif
    </div>
    <!-- Page Title -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Skills</h1>
    </div>

    <!-- Main Content Section -->
    <div class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-6">
        <!-- Table Section (Left Side) -->
        <div class="w-full lg:w-7/12 bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th colspan="2" class="border border-gray-200 px-4 py-2">Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allSkills as $skill)
                        <tr>
                            <td class="border-b border-gray-200 px-4 py-2">{{ $skill->skill_name }}</td>
                            <td class="border-b border-gray-200 px-4 py-2 flex justify-end space-x-2">
                                <button wire:click="editSkill({{$skill->id}})" class="text-blue-500 hover:underline text-sm">
                                    Edit
                                </button>
                                <button wire:click="confirmSkillDeletion({{$skill->id}})" class="text-red-500 hover:underline text-sm">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        @if(count($allSkills) === 0)
                        <tr>
                            <td class="border-b border-gray-200 px-4 py-2 text-center" colspan="2">No skills found.</td>    
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Form Section (Right Side) -->
        <div class="w-full lg:w-5/12 bg-white shadow-lg rounded-lg p-4 border-t border-gray-150">
            <h2 class="text-xl font-semibold mb-4">{{ $currentSkillId && !$isDeleteModalVisible ? 'Edit Skill' : 'Add New Skill' }}</h2>

            <div>
                <form wire:submit.prevent="saveSkill" class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input
                            type="text"
                            id="skillName"
                            wire:model="skillName"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Skill name"
                        >
                        @error('skillName')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="mt-4 px-4 py-2 {{ $currentSkillId && !$isDeleteModalVisible ? 'bg-yellow-500' : 'bg-indigo-600' }} text-white rounded hover:{{ $currentSkillId ? 'bg-yellow-600' : 'bg-indigo-700' }}"
                    >
                        {{ $currentSkillId && !$isDeleteModalVisible ? 'Update' : 'Save' }}
                    </button>

                    @if($currentSkillId && !$isDeleteModalVisible)
                        <button
                            type="button"
                            wire:click="resetFields"
                            class="mt-2 px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500"
                        >
                            Cancel
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div 
        x-data="{ open: @entangle('isDeleteModalVisible') }" 
        x-show="open" 
        x-transition:enter="transition ease-out duration-300 transform" 
        x-transition:enter-start="opacity-0 scale-95" 
        x-transition:enter-end="opacity-100 scale-100" 
        x-transition:leave="transition ease-in duration-200 transform" 
        x-transition:leave-start="opacity-100 scale-100" 
        x-transition:leave-end="opacity-0 scale-95" 
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-50"
    >
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
            <h3 class="text-lg font-bold text-center mb-4">Are you sure you want to delete this skill?</h3>
            <div class="flex justify-between">
                <button wire:click="deleteSkill" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete</button>
                <button wire:click="closeDeleteModal" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
            </div>
        </div>
    </div>
</div>
