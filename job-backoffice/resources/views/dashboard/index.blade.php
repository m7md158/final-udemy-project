<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6 flex flex-col gap-4">
        <!-- Overview Cards -->
        <div class="grid grid-cols-3 gap-6">
            <div class=" p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">Active Users</h3>
                <p class="text-3xl font-bold text-indigo-500">{{ $analytics['activeUsers'] }}</p>
                <p class="text-sm text-gray-500">Last 30 days</p>
            </div>

            <div class=" p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">Active Job Postings</h3>
                <p class="text-3xl font-bold text-indigo-500">{{ $analytics['totalJobs'] }}</p>
                <p class="text-sm text-gray-500">Currently Active</p>
            </div>

            <div class=" p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">Total Applications </h3>
                <p class="text-3xl font-bold text-indigo-500">{{ $analytics['totalApplications'] }}</p>
                <p class="text-sm text-gray-500">All time</p>
            </div>

            
        </div>



        <!-- Most Applied Jobs -->
        <div class=" p-6  bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <h3 class="text-lg font-medium text-gray-900">Most Applied Jobs</h3>

            <div>
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left">
                            <th class="py-2 uppercase text-gray-500">Job Title</th>
                            @if(auth()->user()->role == 'admin')
                                <th class="py-2 uppercase text-gray-500">Company</th>
                            @endif
                            <th class="py-2 uppercase text-gray-500">Total Applications</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($analytics['mostAppliedJobs'] as $mostAppliedJob)
                            <tr>
                                <td class="py-4 ">{{ $mostAppliedJob->title }}</td>
                                @if(auth()->user()->role == 'admin')
                                    <td class="py-4 ">{{ $mostAppliedJob->company->name }}</td>
                                @endif
                                <td class="py-4 ">{{ $mostAppliedJob->totalCount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                
        </div>

        <!-- Conversion Rate -->

        <div class=" p-6  bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <h3 class="text-lg font-medium text-gray-900">Top Converting Job Posts</h3>

            <div>
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left">
                            <th class="py-2 uppercase text-gray-500">Job Title</th>
                            <th class="py-2 uppercase text-gray-500">Views</th>
                            <th class="py-2 uppercase text-gray-500">Applications</th>
                            <th class="py-2 uppercase text-gray-500">Conversion Rate</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($analytics['conversionRates'] as $job)
                            <tr>
                                <td class="py-4 ">{{ $job->title }}</td>
                                <td class="py-4 ">{{ $job->viewsCount }}</td>
                                <td class="py-4 ">{{ $job->totalCount }}</td>
                                <td class="py-4 ">{{ $job->conversionRate }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
