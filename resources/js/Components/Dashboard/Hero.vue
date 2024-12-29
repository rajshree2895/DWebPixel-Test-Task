<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Icon from '../Icon.vue';

// Define the base API URL for the job listings
const API_BASE_URL = 'http://127.0.0.1:8000';

// Reactive variable to store the list of job postings
const jobListings = ref();

// Filters for job search
const searchFilters = ref({
  jobTitle: '',
  jobLocation: '',
});


const fetchJobListings = async () => {
  try {
    const response = await axios.post(`${API_BASE_URL}/api/jobs`, {
      params: {
        title: searchFilters.value.jobTitle,
        location: searchFilters.value.jobLocation,
      },
    });
    console.log(response.data);  // Log the response data
    jobListings.value = response.data;
  } catch (error) {
    console.error('Error fetching job listings:', error);
  }
};

// Fetch all job listings on component mount
onMounted(() => {
  fetchJobListings();
});

</script>

<template>
  <div class="container">
    <div class="bg-slate-100 relative">
      <div class="container py-32 text-center flex flex-col gap-8 relative">
        <div class="space-y-4">
          <h1 class="text-3xl lg:text-6xl font-bold">Find Your Dream Job</h1>
          <p class="text-sm lg:text-base text-slate-600">
            Looking for jobs? Browse our latest job openings and apply today!
          </p>
        </div>

        <!-- Job Search Section -->
        <div>
          <div class="bg-white w-full border rounded-full overflow-hidden border-gray-200 max-w-3xl mx-auto flex items-center justify-center">
            <div class="flex-1 flex items-center border-r">
              <span class="pl-5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
              </span>
              <input
                placeholder="Job title or keyword"
                class="py-4 shadow-none border-none focus:outline-none focus:ring-0 outline-none ring-0"
                type="text"
                v-model="searchFilters.jobTitle"
              />
            </div>
            <div class="flex-1 flex items-center">
              <span class="pl-5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
              </span>
              <input
                placeholder="Location"
                class="py-4 shadow-none border-none focus:outline-none focus:ring-0 outline-none ring-0"
                type="text"
                v-model="searchFilters.jobLocation"
              />
            </div>
            <button @click="fetchJobListings" class="bg-brand px-6 text-sm font-medium py-2 rounded-full text-white mr-3">
              Find Jobs
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Job Listings -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-5">
      <div
        v-for="(job, idx) in jobListings"
        :key="idx"
        class="bg-white border border-gray-200 rounded-lg shadow-md p-6 relative"
      >
        <div class="relative">
          <!-- Job Header -->
          <div class="flex items-start justify-between">
            <div class="flex items-start">
              <img
                :src="`${API_BASE_URL}/storage/${job.job_company_logo}`"
                alt="Company Logo"
                class="h-12 w-auto rounded-full shadow-sm"
              />
              <div class="ml-4">
                <h6 class="text-md font-bold text-gray-800">{{ job.job_title }}</h6>
                <p class="text-sm text-gray-500">{{ job.job_company_name }}</p>
              </div>
            </div>
            <div class="flex flex-wrap gap-2">
              <span
                v-for="(info, idx) in job.job_extra_info.split(',')"
                :key="idx"
                class="bg-amber-100 text-amber-800 text-xs font-medium px-2 py-1 rounded-full"
              >{{ info.trim() }}</span>
            </div>
          </div>

          <!-- Job Details -->
          <div class="mt-4 space-y-2">
            <div class="flex items-center space-x-4 text-xs text-gray-700">
              <div class="flex items-center space-x-1">
                <Icon name="briefcase" class="w-4 h-4 text-gray-600" />
                <span>{{ job.job_experience }}</span>
              </div>
              <span>|</span>
              <div class="flex items-center space-x-1">
                <Icon name="rupee" class="w-4 h-4 text-gray-600" />
                <span>{{ job.job_salary }}</span>
              </div>
              <span>|</span>
              <div class="flex items-center space-x-1">
                <Icon name="location" class="w-4 h-4 text-gray-600" />
                <span>{{ job.job_location }}</span>
              </div>
            </div>

            <p class="text-xs text-gray-600 mt-2">{{ job.job_description }}</p>
          </div>

          <!-- Skills Section -->
          <div class="mt-4">
            <div class="text-xs text-gray-600 flex items-center space-x-2">
              <span
                v-for="(skill, idx) in job.skills"
                :key="idx"
                class="after:content-['•'] after:mx-1 last:after:content-none"
              >{{ skill.skill_name }}</span>
            </div>
          </div>

          <!-- Job Date -->
          <div class="absolute right-1 text-xs text-gray-500">
            {{ job.relative_time }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
