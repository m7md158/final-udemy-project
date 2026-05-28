<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobApplication->user->name }}
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
                <h3 class="text-lg font-bold">Job Application Information</h3>
                <p><strong>Status:</strong> <span class="text-gray-800 font-bold">
                    @if($jobApplication->status == 'accepted')
                        <span class="text-green-700 font-bold">Accepted</span>
                    @elseif($jobApplication->status == 'rejected')
                        <span class="text-red-700">Rejected</span>
                    @else
                        <span class="text-yellow-700">Pending</span>
                    @endif
                </span></p>
                <p><strong>AI Generated Score:</strong> <span class="text-gray-800 font-bold">{{ $jobApplication->aiGeneratedScore }}</span></p>
                <p><strong>AI Generated Feedback:</strong> <span class="text-gray-800 font-bold">{{ $jobApplication->aiGeneratedFeedback }}</span></p>
                <p><strong>Job Vacancy:</strong> <span class="text-gray-800 font-bold">{{ $jobApplication->jobVacancy->title }}</span></p>
                <p><strong>User:</strong> <span class="text-gray-800 font-bold">{{ $jobApplication->user->name }}</span></p>
                <p><strong>Resume:</strong> <a  class="text-blue-500 hover:text-blue-700 underline" href="{{ $jobApplication->resume->fileUri }}" target="_blank">{{ $jobApplication->resume->fileName }}</a></p>
            </div>

            <!-- Edit and Archive Buttons -->
            <div class="flex justify-end space-x-4 mb-6">
                @if (auth()->user()->role == 'admin')
                    <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Archive</button>
                    </form>
                @endif

                @if (auth()->user()->role == 'admin')
                    <a href="{{ route('job-applications.edit', $jobApplication->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Edit</a>
                @endif
            </div>

            @if (auth()->user()->role == 'admin')
                    <!-- Tabs Navigation -->
                    <div class="mb-6">
                        <ul class="flex space-x-4">
                        
                            <li>
                                <a href="{{ route('job-applications.show', ['job_application' => $jobApplication->id, 'tab' => 'Resume']) }}"
                                    class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') == 'Resume' ? 'border-b-2 border-blue-500' : '' }}">Resume</a>
                            </li>
                            <li>
                                <a href="{{ route('job-applications.show', ['job_application' => $jobApplication->id, 'tab' => 'AIFeedback']) }}"
                                    class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') == 'AIFeedback' ? 'border-b-2 border-blue-500' : '' }}">AI Feedback</a>
                            </li>
                        </ul>
                    </div>

                    
                
                        <!-- Resume Tab -->
                        <div id="Resume" class="{{ request('tab') == 'Resume' || request('tab') == '' ? 'block' : 'hidden' }}">
                            <table class="min-w-full bg-gray-50 rounded-lg shadow active">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Summary</th>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Skills</th>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Experience</th>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Education</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-2 px-4">{{ $jobApplication->resume->summary }}</td>
                                        <td class="py-2 px-4">{{ $jobApplication->resume->skills }}</td>
                                        <td class="py-2 px-4">{{ $jobApplication->resume->experience }}</td>
                                        <td class="py-2 px-4">{{ $jobApplication->resume->education }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- AI Feedback Tab -->
                        <div id="AIFeedback" class="{{ request('tab') == 'AIFeedback' || request('tab') == '' ? 'block' : 'hidden' }}">
                            <table class="min-w-full bg-gray-50 rounded-lg shadow active">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">AI Score</th>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">AI Feedback</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-2 px-4">{{ $jobApplication->aiGeneratedScore }}</td>
                                        <td class="py-2 px-4">{{ $jobApplication->aiGeneratedFeedback }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
    </div>
</x-app-layout>