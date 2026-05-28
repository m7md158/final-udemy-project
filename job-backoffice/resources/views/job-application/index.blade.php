<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Applications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Job Applications") }}
                </div>


                <x-toast-notification />
                <div class="flex justify-end items-center space-x-4">
                    @if(request()->input('archived') == 'true')
                        <!-- Active -->
                        <a href="{{ route('job-applications.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Active Job Applications
                        </a>
                    @else
                        <!-- Archived -->
                        <a href="{{ route('job-applications.index', ['archived' => 'true']) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Archived Job Applications
                        </a>
                    @endif
                </div>


                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <!-- name is link to show page -->
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Name</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Job Vacancy</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Status</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobApplications as $jobApplication)
                                <tr>
                                    <!-- name is link to show page -->
                                    <td class="py-2 px-4 text-gray-800">
                                        <a href="{{ route('job-applications.show', $jobApplication->id) }}" class="text-blue-500 hover:text-blue-700 underline">
                                            {{ $jobApplication->user->name ?? 'N/A' }}
                                        </a>
                                    </td>
                                    <td class="py-2 px-4 text-gray-800">{{ $jobApplication->jobVacancy->title ?? 'N/A' }}</td>
                                    <!-- if status is accepted show green , rejected show red , pending show yellow -->
                                    <td class="py-2 px-4 text-gray-800">
                                        @if($jobApplication->status == 'accepted')
                                            <span class="text-green-700 font-bold">Accepted</span>
                                        @elseif($jobApplication->status == 'rejected')
                                            <span class="text-red-700">Rejected</span>
                                        @else
                                            <span class="text-yellow-700">Pending</span>
                                        @endif
                                    </td>
                                
                                    <td>
                                        <div class="flex space-x-4">
                                            @if(request()->input('archived') == 'true')
                                                <!-- Restore Button -->
                                                <form action="{{ route('job-applications.restore', $jobApplication->id) }}" method="POST"
                                                    class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="text-green-500 hover:text-green-700">🔄 Restore</button>
                                                </form>
                                            @else
                                                <!-- Edit Button -->
                                                <a href="{{ route('job-applications.edit', $jobApplication->id) }}"
                                                    class="text-blue-500 hover:text-blue-700">✍️ Edit</a>

                                                <!-- Archive Button -->
                                                <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="POST"
                                                    class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">🗃️ Archive</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-gray-800">No job applications found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $jobApplications->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
