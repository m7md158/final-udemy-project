<nav class="w-[250px] h-screen bg-white broder-r border-gray-200">

    <!-- application logo -->
    <div class="flex items-center px-6 border-b border-gray-200 py-4">
        <a href="{{route('dashboard')}} " class="flex text-2xl font-bold  items-center gap-2">
        <x-application-logo class="h-6 w-auto fill-current text-gray-800" />
        <span class="text-lg font-semibold text-gray-800">Shaghalni</span>
        </a>
    </div>

    <!-- navigation links -->
    <ul  class="flex flex-col px-4 py-6 space-y-2">
        <x-nav-link href="{{route('dashboard')}}" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-nav-link>

        @if(auth()->user()->role == 'admin')
            <x-nav-link href="{{route('companies.index')}}" :active="request()->routeIs('company.index')">
                Companies
            </x-nav-link>
        @endif
        <!-- my company -->
        @if(auth()->user()->role == 'company-owner')
            <x-nav-link href="{{route('my-company.show')}}" :active="request()->routeIs('my-company.show')">
                My Company
            </x-nav-link>
        @endif


        <x-nav-link href="{{route('job-applications.index')}}" :active="request()->routeIs('application.index')">
            Job Applications
        </x-nav-link>

        @if(auth()->user()->role == 'admin')
        
            <x-nav-link href="{{route('job-categories.index')}}" :active="request()->routeIs('job-categories.index')">
                Job Categories
            </x-nav-link>
        
        @endif

        <x-nav-link href="{{route('job-vacancies.index')}}" :active="request()->routeIs('vacancy.index')">
            Job Vacancies
        </x-nav-link>

        @if(auth()->user()->role == 'admin')
            <x-nav-link href="{{route('users.index')}}" :active="request()->routeIs('user.index')">
                Users
            </x-nav-link>
        @endif

        <!-- logout -->
        <hr/>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center px-4 py-2 w-full text-sm font-medium text-red-500 hover:text-red-700 hover:bg-gray-100 rounded-md focus:outline-none focus:bg-gray-200 transition duration-150 ease-in-out text-left">
                    Logout
                </button>
            </form>
        </li>

       


    </ul>


</nav>