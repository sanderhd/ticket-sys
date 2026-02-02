<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl text-gray-800 font-semibold">Mijn tickets</h2>
            <button onclick="window.location='{{ route('tickets.create') }}'" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Nieuwe ticket</button>
        </div>
    </x-slot>

    <div class="p-6">
        <form method="GET" class="bg-white border border-gray-300 rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Zoeken</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full p-2 border border-gray-300 rounded" placeholder="Zoek in titel of beschrijving">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="w-full p-2 border border-gray-300 rounded">
                        <option value="">Alle</option>
                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Prioriteit</label>
                    <select name="priority" class="w-full p-2 border border-gray-300 rounded">
                        <option value="">Alle</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Laag</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Hoog</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Labels</label>
                    <input type="text" name="labels" value="{{ request('labels') }}" class="w-full p-2 border border-gray-300 rounded" placeholder="Zoek labels">
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Filteren</button>
        </form>
    </div>

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

                @if(auth()->user()->isPro())
                    @php
                        $priorityColors = [
                            'low' => 'bg-green-100 text-green-700',
                            'medium' => 'bg-yellow-100 text-yellow-700',
                            'high' => 'bg-red-100 text-red-700',
                        ];
                    @endphp

                    <div class="flex flex-wrap gap-2 mb-3">
                        @if($ticket->priority)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $priorityColors[$ticket->priority] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        @endif

                        @if($ticket->labels)
                            @foreach(explode(',', $ticket->labels) as $label)
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    bg-blue-100 text-blue-700">
                                    {{ trim($label) }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                @endif

                <button 
                    onclick="window.location='{{ route('tickets.show', $ticket) }}'" 
                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded transition">
                    Bekijk →
                </button>
            </div>
        @endforeach
    </div>
</x-app-layout>