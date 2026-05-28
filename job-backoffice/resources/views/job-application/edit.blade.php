<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Application') . ' - ' . $jobApplication->user->name }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <form action="{{ route('job-applications.update', $jobApplication->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Job Vacancy Details -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold"> Job Application Details</h3>
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700"> Name</label>
                        <span>{{ $jobApplication->user->name }}</span>
                        
                    </div>

                    <div class="mb-4">
                        <label for="location" class="block text-sm font-medium text-gray-700"> AI Generated Score</label>
                        <span>{{ $jobApplication->aiGeneratedScore }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="salary" class="block text-sm font-medium text-gray-700"> AI Feedback</label>
                        <span>{{ $jobApplication->aiGeneratedFeedback }}</span>
                    </div>

                    

                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Job Vacancy</h3>
                        <span>{{ $jobApplication->jobVacancy->title }}</span>
                    </div>
                    <!-- Job Category select dropdown -->
                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Resume</h3>
                        <span class="text-blue-500 hover:text-blue-700 underline"><a href="{{ $jobApplication->resume->fileUri }}" target="_blank">{{ $jobApplication->resume->fileName }}</a></span>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="pending" {{ $jobApplication->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ $jobApplication->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected" {{ $jobApplication->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('job-applications.show', $jobApplication->id) }}"
                        class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Job Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>