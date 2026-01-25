<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Picture') }}
        </h2>

        <p class="mt-1 text-sm text-gray-700">
            {{ __('Upload a new profile picture.') }}
        </p>
    </header>

    <form
        method="post"
        action="{{  route('profile.update') }}"
        enctype="multipart/form-data"
        class="space-y-6"
    >
        @csrf
        @method('patch')

        <div class="flex items-center gap-4">
            <img
                class="h-16 w-16 rounded-full object-cover"
                src="{{ auth()->user()->profile_photo
                    ? asset('storage/' . auth()->user()->profile_photo)
                    : 'http://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) 
                }}"
                alt="Profile Picture"
            />
        </div>

        <div>
            <x-input-label for="profile_photo" value="{{ __('Profile photo') }}" />
            <input
                id="profile_photo"
                name="profile_photo"
                type="file"
                accept="image/*"
                class="mt-1 block w-full text-sm text-gray-700"
            />
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
</form>
</section>