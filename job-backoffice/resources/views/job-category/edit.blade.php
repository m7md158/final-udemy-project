<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Category') }}
            <div class="overflow-x-auto">
            </div>
        </h2>
    </x-slot>

        @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded text-center">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 text-white p-3 rounded text-center">
                {{ session('error') }}
            </div>
        @endif

    <!-- edit form -->
    <form action="{{route('job-categories.update',  $category->id)}}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <!-- old name must be  -->
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $category->name }}">
            @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>




        <div class="flex justify-end space-x-4">
                    <a href="{{ route('job-categories.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Update Category
                    </button>
        </div>
    </form>
   
</x-app-layout>
