<nav class="w-full flex items-center justify-between px-8 py-4 bg-gray-50 border-b">
    <div>
        <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
            <x-application-logo class="w-10 h-10 fill-current text-blue-600 group-hover:text-blue-800 transition" />
            <span class="text-2xl font-bold text-gray-800 group-hover:text-blue-800 transition">Ticket <span class="text-blue-600">Flow</span></span>
        </a>
    </div>

    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <x-nav-link :href="route('over-ons')">
            Over Ons
        </x-nav-link>

        <x-nav-link :href="route('prijzen')">
            Prijzen
            
        </x-nav-link>

        <div class="relative group">
            <button
                class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-800 transition">
                Product
                <svg class="ms-1 h-4 w-4 fill-current transition-transform group-hover:rotate-180"
                    viewBox="0 0 20 20">
                    <path d="M5.293 7.293L10 12l4.707-4.707z" />
                </svg>
            </button>

            <div
                class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg
                    opacity-0 invisible group-hover:visible group-hover:opacity-100
                    transition-all duration-150 z-50">

                <a href="{{ route('over-ons') }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Features
                </a>

                <a href="{{ route('over-ons') }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Demo
                </a>

                <a href="{{ route('over-ons') }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Updates
                </a>
            </div>
        </div>


        <div class="relative group">
            <button
                class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-800 transition">
                Support
                <svg class="ms-1 h-4 w-4 fill-current transition-transform group-hover:rotate-180"
                    viewBox="0 0 20 20">
                    <path d="M5.293 7.293L10 12l4.707-4.707z" />
                </svg>
            </button>

            <div
                class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg
                    opacity-0 invisible group-hover:visible group-hover:opacity-100
                    transition-all duration-150 z-50">

                <a href="{{ route('over-ons') }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Documentatie
                </a>

                <a href="{{ route('over-ons') }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    FAQ
                </a>

                <a href="{{ route('over-ons') }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Status
                </a>
            </div>
        </div>

        <x-nav-link :href="route('over-ons')">
            Contact
        </x-nav-link>
    </div>

    <div class="hidden sm:flex sm:items-center sm:ms-6">
        @auth
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    <div class="flex items-center">
                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo 
                            ? asset('storage/' . auth()->user()->profile_photo)
                            : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name)
                            }}" alt="{{ Auth::user()->name }}" />

                        <span class="ms-2">{{ Auth::user()->name }}</span>
                    </div>

                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('tickets.index')">
                    {{ __('Mijn Tickets') }}
                </x-dropdown-link>

                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Instellingen') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        {{ __('Uitloggen') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
        @else
        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
        @endauth
    </div>
</nav>