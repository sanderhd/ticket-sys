<x-guest-layout>
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl px-8 py-10">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">
                Welkom terug bij <span class="text-blue-600">TicketFlow</span>
            </h1>
            <p class="mt-2 text-sm text-gray-500">
                Log in om je tickets te beheren
            </p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <x-input-label for="email" value="Emailadres" />
                <x-text-input
                    id="email"
                    type="email"
                    name="email"
                    class="mt-1 block w-full"
                    :value="old('email')"
                    required
                    autofocus
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" value="Wachtwoord" />
                <x-text-input
                    id="password"
                    type="password"
                    name="password"
                    class="mt-1 block w-full"
                    required
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center text-sm text-gray-600">
                    <input
                        id="remember_me"
                        type="checkbox"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        name="remember"
                    />
                    <span class="ms-2">Onthoud mij</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-blue-600 hover:underline">
                        Wachtwoord vergeten?
                    </a>
                @endif
            </div>

            <x-primary-button class="w-full justify-center py-3 text-base">
                Inloggen
            </x-primary-button>

            <p class="text-center text-sm text-gray-500">
                Nog geen account?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">
                    Registreren
                </a>
            </p>
        </form>
    </div>
</x-guest-layout>
