<nav class="w-full flex items-center justify-between px-8 py-4 bg-gray-50 border-b">
    <div>
        <a href="{{ url('/') }}">
            <x-application-logo class="w-10 h-10 fill-current text-gray-600" />
        </a>
    </div>

    <div class="hidden sm:flex sm:items-center sm:ms-6">
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
    </div>
</nav>