<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\JobCategory;
use App\Models\Company;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\JobApplication;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // seed admin user
        User::firstOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('123456789'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // seed data to test with job data and job applications
        $jobData = json_decode(file_get_contents(database_path('data/job_data.json')),  true);

        // job applications data
        $jobApplicationsData = json_decode(file_get_contents(database_path('data/job_applications.json')), true)['jobApplications'];

        // seed job jobCategories
        foreach ($jobData['jobCategories'] as $category) {

            JobCategory::firstOrCreate([
                'name' => $category,
            ]);
        }


        // seed companies
        foreach ($jobData['companies'] as $company) {
            // create owner first
            $companyOwner = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail(),
            ], [
                'name' => fake()->name(),
                'password' => Hash::make('123456789'),
                'role' => 'company-owner',
                'email_verified_at' => now(),
            ]);

            Company::firstOrCreate([
                'name' => $company['name'],
                'address' => $company['address'],
                'industry' => $company['industry'],
                'website' => $company['website'],
                'ownerId' => $companyOwner->id,
            ]);
        }

            // create job vacancies 
        foreach ($jobData['jobVacancies'] as $jobVacancy) {

                $jobCategory = JobCategory::where('name', $jobVacancy['category'])->firstOrFail();
                $company = Company::where('name', $jobVacancy['company'])->firstOrFail();

                JobVacancy::firstOrCreate([
                    'title' => $jobVacancy['title'],
                    'companyId' => $company->id,
                ], [
                    'description' => $jobVacancy['description'],
                    'location' => $jobVacancy['location'],
                    'salary' => $jobVacancy['salary'],
                    'type' => $jobVacancy['type'],
                    'jobCategoryId' => $jobCategory->id,
                ]);


        }

        // create job applications
        // create job applications
        foreach ($jobApplicationsData as $jobApplication) {
            // get random job vacancy
            $jobVacancy = JobVacancy::inRandomOrder()->firstOrFail();

            // create job seeker user
            $applicant = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail(),
            ], [
                'name' => fake()->name(),
                'password' => Hash::make('123456789'),
                'role' => 'job-seeker',
                'email_verified_at' => now(),
            ]);

            // resume data
            $resumeData = $jobApplication['resume'];

            // create resume
            $resume = Resume::firstOrCreate([
                'userId' => $applicant->id,
                'fileName' => $resumeData['filename'],
                'fileUri' => $resumeData['fileUri'],
                'contactDetails' => $resumeData['contactDetails'],
                'summary' => $resumeData['summary'],
                'skills' => $resumeData['skills'],
                'experience' => $resumeData['experience'],
                'education' => $resumeData['education'],
            ]);

            // create job application
            JobApplication::firstOrCreate([
                'jobVacancyId' => $jobVacancy->id,
                'userId' => $applicant->id,
                'resumeId' => $resume->id,
            ], [
                'status' => $jobApplication['status'],
                'aiGeneratedScore' => $jobApplication['aiGeneratedScore'],
                'aiGeneratedFeedback' => $jobApplication['aiGeneratedFeedback'],
            ]);
        }
    }
}
