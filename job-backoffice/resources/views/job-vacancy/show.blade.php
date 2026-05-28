<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        @if (auth()->user()->role == 'admin')
            <!-- Back Button -->
            <div class="mb-6">
                    <a href="{{ route('job-vacancies.index') }}"
                    class="bg-gray-200 text-gray-800 hover:bg-gray-300 px-4 py-2 rounded-md">← Back</a>
            </div>
        @endif

        <!-- Wrapper -->
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
            <!-- Company Details -->
            <div>
                <h3 class="text-lg font-bold">Job Vacancy Information</h3>
                <p><strong>Description:</strong> {{ $jobVacancy->description }}</p>
                <p><strong>Location:</strong> {{ $jobVacancy->location }}</p>
                <p><strong>Salary:</strong> ${{ number_format($jobVacancy->salary, 2) }}</p>
                <p><strong>Type:</strong> {{ $jobVacancy->type }}</p>
                <p><strong>Category:</strong> {{ $jobVacancy->jobCategory->name }}</p>
                <p><strong>Company:</strong> {{ $jobVacancy->company->name }}</p>
            </div>

            <!-- Edit and Archive Buttons -->
            <div class="flex justify-end space-x-4 mb-6">
                @if (auth()->user()->role == 'admin')
                    <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Archive</button>
                    </form>
                @endif

                @if (auth()->user()->role == 'admin')
                    <a href="{{ route('job-vacancies.edit', $jobVacancy->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Edit</a>
                @endif
            </div>

            @if (auth()->user()->role == 'admin')
                    <!-- Tabs Navigation -->
                    <div class="mb-6">
                        <ul class="flex space-x-4">
                        
                            <li>
                                <a href="{{ route('job-vacancies.show', ['job_vacancy' => $jobVacancy->id, 'tab' => 'applications']) }}"
                                    class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') == 'applications' ? 'border-b-2 border-blue-500' : '' }}">Applications</a>
                            </li>
                        </ul>
                    </div>


                    <!-- Tab Content -->
                    
                
                        <!-- Applications Tab -->
                        <div id="applications" class="{{ request('tab') == 'applications' || request('tab') == '' ? 'block' : 'active' }}">
                            <table class="min-w-full bg-gray-50 rounded-lg shadow active">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">ApplicantName</th>
                                        <th class="py-2 px-4 text-left bg-gray-100">Job Title</th>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Status</th>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($jobVacancy->jobApplications as $jobApplication)
                                        <tr>
                                            <td class="py-2 px-4">{{ $jobApplication->user->name }}</td>
                                            <td class="py-2 px-4">{{ $jobApplication->jobVacancy->title }}</td>
                                            <td class="py-2 px-4">{{ $jobApplication->status }}</td>
                                            <td class="py-2 px-4">
                                                <a href="{{ route('job-applications.show', ['job_application' => $jobApplication->id]) }}"
                                                    class="text-blue-500 hover:text-blue-700 underline">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-2 px-4 text-center">No applications found</td>
                                        </tr>
                                    @endforelse
                                    
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            @endif
    </div>

</x-app-layout>