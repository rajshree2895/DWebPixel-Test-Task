<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterJob;
use Carbon\Carbon;
use Log;

class APIController extends Controller
{
    public function index(Request $request)
    {

        $query = MasterJob::query();
        $filters = $request->all()['params'] ?? [];

        if ($filters['title']) {
            $title = $filters['title'];
            $query->where(function ($subQuery) use ($title) {
                $subQuery->where('job_title', 'like', "%$title%")
                    ->orWhere('job_extra_info', 'like', "%$title%")
                    ->orWhereHas('skills', function ($skillQuery) use ($title) {
                        $skillQuery->where('skill_name', 'like', "%$title%");
                    });
            });
        }


        if ($filters['location']) {
            $location = $filters['location'];
            $query->where(function ($subQuery) use ($location) {
                $subQuery->where('job_location', 'like', "%$location%")
                    ->orWhere('job_extra_info', 'like', "%$location%");
            });
        }


        $jobs = $query->with(['skills'])->get();


        $jobs->transform(function ($job) {
            $job->relative_time = Carbon::parse($job->created_at)->diffForHumans();
            return $job;
        });

        return response()->json($jobs);
    }
}
