<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl text-white font-semibold">Nieuwe Ticket</h2>
            <button onclick="window.location='{{ route('tickets.index') }}'" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Mijn tickets</button>
        </div>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto">
        <form method="POST" action="{{ route('tickets.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm text-gray-700 font-medium">Titel</label>
                <input 
                    type="text"
                    name="title"
                    class="w-full mt-1 rounded border-gray-300"
                />
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-700 font-medium">Beschrijving</label>
                <textarea 
                    name="description"
                    rows="4"
                    class="w-full mt-1 rounded border-gray-300"
                ></textarea>
            </div>

            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Ticket aanmaken
            </button>
        </form>
    </div>
</x-app-layout>