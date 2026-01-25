<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl text-white font-semibold">Mijn tickets</h2>
            <button onclick="window.location='{{ route('tickets.create') }}'" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Nieuwe ticket</button>
        </div>
    </x-slot>

    <div class="p-4 space-y-4">
        @foreach ($tickets as $ticket)
            <div class="p-4 border rounded">
                <h3 class="font-semibold text-white">{{ $ticket->title }}</h3>
                <p class="text-sm text-gray-600">{{ $ticket->description }}</p>
                <span class="text-xs px-2 py-1 rounded text-white {{ $ticket->status === 'open' ? 'bg-yellow-500' : ($ticket->status === 'in_progresfs' ? 'bg-blue-500' : 'bg-green-500') }}">{{ $ticket->status }}</span>

                <button onclick="window.location='{{ route('tickets.show', $ticket) }}'" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Bekijk</button>
            </div>
        @endforeach
    </div>
</x-app-layout>