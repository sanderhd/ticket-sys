<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl text-gray-800 font-semibold">Mijn tickets</h2>
            <button onclick="window.location='{{ route('tickets.create') }}'" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Nieuwe ticket</button>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
        @foreach ($tickets as $ticket)
            <div class="bg-white border border-gray-300 rounded-lg p-6 shadow-md hover:shadow-lg hover:border-blue-500 transition">
                <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full mb-3
                    {{ 
                        $ticket->status === 'open' ? 'bg-yellow-500 text-black' : 
                        ($ticket->status === 'in_progress' ? 'bg-blue-500 text-white' : 'bg-green-500 text-white') 
                    }}">
                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                </span>

                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    {{ $ticket->title }}
                </h3>

                <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                    {{ $ticket->description }}
                </p>

                <button 
                    onclick="window.location='{{ route('tickets.show', $ticket) }}'" 
                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded transition">
                    Bekijk →
                </button>
            </div>
        @endforeach
    </div>
</x-app-layout>