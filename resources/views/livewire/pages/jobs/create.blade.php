<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Post a New Job</h1>
    </div>

    <div x-data="{ isMessageVisible: false }" 
         x-init="$watch('isMessageVisible', value => { if (value) setTimeout(() => isMessageVisible = false, 3000); })"
         x-show="isMessageVisible"
         class="transition-all duration-500 ease-in-out">
        @if(session()->has('message'))
            <div class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg mb-4" x-init="isMessageVisible = true">
                {{ session('message') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg mb-4" x-init="isMessageVisible = true">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <form wire:submit.prevent="saveJob" class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Left Section -->
        <div class="space-y-6">
            <div>
                <label for="jobTitle" class="block text-sm font-medium text-gray-700">Job Title</label>
                <input type="text" id="jobTitle" wire:model="jobTitle" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter job title">
                @error('jobTitle') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
    
            <div>
                <label for="jobDescription" class="block text-sm font-medium text-gray-700">Job Description</label>
                <textarea id="jobDescription" wire:model="jobDescription" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter job description"></textarea>
                @error('jobDescription') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
    
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="jobExperience" class="block text-sm font-medium text-gray-700">Experience</label>
                    <input type="text" id="jobExperience" wire:model="jobExperience" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g., 4-5 years">
                    @error('jobExperience') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
    
                <div>
                    <label for="jobSalary" class="block text-sm font-medium text-gray-700">Salary</label>
                    <input type="text" id="jobSalary" wire:model="jobSalary" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g., 3 to 4 LPA">
                    @error('jobSalary') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
    
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="jobLocation" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" id="jobLocation" wire:model="jobLocation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g., Remote / Pune">
                    @error('jobLocation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
    
                <div>
                    <label for="jobExtraInfo" class="block text-sm font-medium text-gray-700">Extra Information</label>
                    <input type="text" id="jobExtraInfo" wire:model="jobExtraInfo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g., Full time, Urgent">
                    <p class="mt-1 text-sm text-gray-500">Please use comma separated values</p>
                    @error('jobExtraInfo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    
        <!-- Right Section -->
        <div class="space-y-6">
            <div>
                <label for="companyName" class="block text-sm font-medium text-gray-700">Company Name</label>
                <input type="text" id="companyName" wire:model="companyName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter company name">
                @error('companyName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
    
            <div>
                <label for="companyLogo" class="block text-sm font-medium text-gray-700">Company Logo</label>
                <input type="file" id="companyLogo" wire:model="companyLogo" class="mt-1 block w-full text-sm">
                @error('companyLogo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
    
            <div>
                <label for="skillsRequired" class="block text-sm font-medium text-gray-700">Skills</label>
                @if(count($skills) === 0)
                    <p class="text-sm text-gray-500">No skills found. Please add some skills first.</p>
                @else
                <select wire:model="selectedSkills" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @foreach($skills as $skill)
                        <option value="{{ $skill->id }}">{{ $skill->skill_name }}</option>
                    @endforeach
                </select>
                @endif
                @error('selectedSkills') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
    
        <!-- Submit Button -->
        <div class="flex">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Post Job</button>
        </div>
    </form>
    
</div>
