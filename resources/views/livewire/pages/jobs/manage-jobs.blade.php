<div>
    <div class="container mx-auto py-4">
        <div class="flex justify-between items-center py-8">
            <h1 class="text-2xl font-bold">Jobs</h1>
        </div>

        <div 
            x-data="{ showMessage: false }" 
            x-init="$watch('showMessage', value => { if (value) setTimeout(() => showMessage = false, 3000); })"
            x-show="showMessage"
            class="transition-all duration-500 ease-in-out"
        >
            @if(session()->has('message'))
                <div 
                    class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg mb-4"
                    x-init="showMessage = true"
                >
                    {{ session('message') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div 
                    class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg mb-4"
                    x-init="showMessage = true"
                >
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="w-full">
            @if ($jobList && count($jobList) > 0)
                <!-- Job List -->
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Title</th>
                                    <th scope="col" class="px-4 py-3">Description</th>
                                    <th scope="col" class="px-4 py-3">Company Logo</th>
                                    <th scope="col" class="px-4 py-3">Company Name</th>
                                    <th scope="col" class="px-4 py-3">Experience</th>
                                    <th scope="col" class="px-4 py-3">Salary</th>
                                    <th scope="col" class="px-4 py-3">Location</th>
                                    <th scope="col" class="px-4 py-3">Skills</th>
                                    <th scope="col" class="px-4 py-3">Extra</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobList as $job)
                                    <tr class="border-b dark:border-gray-700">
                                        <th scope="row" class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap dark:text-white">{{ $job['job_title'] }}</th>
                                        <td class="px-4 py-3 whitespace-nowrap" title="{{ $job['job_description'] }}">
                                            {{ str($job['job_description'])->words(7) }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <img src="{{ asset('storage/'.$job['job_company_logo']) }}" class="h-10 w-auto" alt="Logo" />
                                        </td>
                                        <td><span class="font-medium text-gray-900">{{ $job['job_company_name'] }}</span></td>
                                        <td class="px-4 py-3">{{ $job['job_experience'] }}</td>
                                        <td class="px-4 py-3">{{ $job['job_salary'] }}</td>
                                        <td class="px-4 py-3">{{ $job['job_location'] }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center flex-wrap gap-2">
                                                @foreach ($job['skills'] as $skill)
                                                    <span class="inline-block bg-gray-200 rounded-full px-2 py-0.5 text-xs font-medium text-gray-700">{{ $skill['skill_name'] }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center flex-wrap gap-2">
                                                @foreach (explode(',', $job['job_extra_info']) as $info)
                                                    <span class="inline-block bg-amber-100 rounded-full px-2 py-0.5 text-xs font-medium text-amber-800">
                                                        {{ trim($info) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 flex items-center justify-end">
                                            <button 
                                                wire:click="promptDelete({{ $job['id'] }})" 
                                                class="text-sm px-3 py-1.5 rounded hover:bg-slate-100 transition-colors text-red-500"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- No Job Postings Found -->
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">No job postings found.</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if ($showConfirmDeleteModal)
        <div class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-1/3">
                <div class="px-6 py-4">
                    <h2 class="text-lg font-bold text-gray-900">Confirm Deletion</h2>
                    <p class="text-sm text-gray-700 mt-2">Are you sure you want to delete this job?</p>
                </div>
                <div class="px-6 py-4 flex justify-end gap-4">
                    <button 
                        wire:click="closeModal" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300"
                    >
                        Cancel
                    </button>
                    <button 
                        wire:click="performDelete" 
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
