<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobVacancy;
use App\Models\JobApplication;
class DashboardController extends Controller
{
    public function index()
    {
        // get the analytics for company owner
        if(auth()->user()->role == 'admin'){
            $analytics = $this->adminDashboard();
        }
        else
        {
            $analytics = $this->companyOwnerDashboard();
        }


        return view('dashboard.index', compact('analytics'));
    }

    private function adminDashboard()
    {
        // last 30 days active users(job seeker role)
        $activeUsers = User::where('role', 'job-seeker')->where('last_login_at', '>=', now()->subDays(30))->count();

        // total jobs(not deleted)
        $totalJobs = JobVacancy::where('deleted_at', null)->count();

        // total applications(not deleted)
        $totalApplications = JobApplication::where('deleted_at', null)->count();


        // most applied jobs
        $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalCount')
        ->whereNull('deleted_at')
        ->orderByDesc('totalCount')
        ->limit(5)
        ->get();


        // top converting jobs
        $conversionRates = JobVacancy::withCount('jobApplications as totalCount')
        ->having('totalCount', '>', 0)
        ->limit(5)
        ->orderByDesc('totalCount')
        ->get()
        ->map(function($job){
            if($job->viewsCount > 0){
                $job->conversionRate = round($job->totalCount / $job->viewsCount * 100, 2);
            } else {
                $job->conversionRate = 0;
            }
            return $job;
        });
        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates,
        ];
        return $analytics;

    }


    private function companyOwnerDashboard()
    {

        $company = auth()->user()->company;

        // activeUsers : filter active users by apply to job of the company
        $activeUsers = User::where('role', 'job-seeker')->where('last_login_at', '>=', now()->subDays(30))
        ->whereHas('jobApplications', function ($query) use ($company) {
            $query->whereIn('jobVacancyId', $company->jobVacancies->pluck('id'));
        })
        ->count();

        // total jobs(not deleted)
        $totalJobs = JobVacancy::where('companyId', auth()->user()->company->id)
            ->whereNull('deleted_at')
            ->count();

        // total applications(not deleted)
        $totalApplications = JobApplication::whereHas('jobVacancy', function ($query) {
            $query->where('companyId', auth()->user()->company->id);
        })->whereNull('deleted_at')->count();

        // most applied jobs
        $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalCount')
        ->where('companyId', $company->id)
        ->whereNull('deleted_at')
        ->orderByDesc('totalCount')
        ->limit(5)
        ->get();


        // top converting jobs
        $conversionRates = JobVacancy::withCount('jobApplications as totalCount')
        ->where('companyId', $company->id)
        ->having('totalCount', '>', 0)
        ->limit(5)
        ->orderByDesc('totalCount')
        ->get()
        ->map(function($job){
            if($job->viewsCount > 0){
                $job->conversionRate = round($job->totalCount / $job->viewsCount * 100, 2);
            } else {
                $job->conversionRate = 0;
            }
            return $job;
        });


        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates,
        ];

        return $analytics;
    }


   
}
