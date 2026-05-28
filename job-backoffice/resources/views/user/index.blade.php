<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Users") }}
                </div>


                <x-toast-notification />
                <div class="flex justify-end items-center space-x-4">
                    @if(request()->input('archived') == 'true')
                        <!-- Active -->
                        <a href="{{ route('users.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Active Users
                        </a>
                    @else
                        <!-- Archived -->
                        <a href="{{ route('users.index', ['archived' => 'true']) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Archived Users
                        </a>
                    @endif
                </div>


                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <!-- name is link to show page -->
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Name</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Email</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Role</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <!-- name is link to show page -->
                                    <td class="py-2 px-4 text-gray-800">
                                        {{ $user->name ?? 'N/A' }}
                                    </td>
                                    <td class="py-2 px-4 text-gray-800">{{ $user->email ?? 'N/A' }}</td>
                                    <!-- if status is accepted show green , rejected show red , pending show yellow -->
                                    <td class="py-2 px-4 text-gray-800">
                                        {{ $user->role ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <div class="flex space-x-4">
                                            @if(request()->input('archived') == 'true')
                                                <!-- Restore Button -->
                                                <form action="{{ route('users.restore', $user->id) }}" method="POST"
                                                    class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="text-green-500 hover:text-green-700">🔄 Restore</button>
                                                </form>
                                            @else

                                                <!-- Edit Button -->
                                                @if($user->role != 'admin')
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="text-blue-500 hover:text-blue-700">✍️ Edit</a>

                                                <!-- Archive Button -->
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">🗃️ Archive</button>
                                                </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-gray-800">No users found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
