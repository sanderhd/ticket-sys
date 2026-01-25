<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl text-white font-semibold">Ticket #{{ $ticket->id }} | {{ $ticket->title }}</h2>
            <button onclick="window.location='{{ route('tickets.index') }}'" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Mijn tickets</button>
        </div>
    </x-slot>

    <div class="p-6 space-y-6">
        <!-- Ticket Details -->
        <div class="bg-gray-800 p-6 border border-gray-700 rounded-lg">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="font-bold text-2xl text-white">{{ $ticket->title }}</h3>
                    <p class="text-gray-400 text-sm mt-1">Aangemaakt: {{ $ticket->created_at->format('d-m-Y H:i') }}</p>
                </div>
                <span class="px-4 py-2 rounded-full text-white font-semibold text-sm
                    @if($ticket->status === 'open') bg-blue-600
                    @elseif($ticket->status === 'in_progress') bg-yellow-600
                    @elseif($ticket->status === 'closed') bg-green-600
                    @else bg-gray-600 @endif">
                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                </span>
            </div>
            <p class="text-gray-300 leading-relaxed">{{ $ticket->description }}</p>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="bg-gray-800 p-6 border border-gray-700 rounded-lg">
            <h4 class="font-bold text-lg text-white mb-4">Admin</h4>
            <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="flex gap-4 items-end">
                @csrf
                @method('PATCH')
                
                <div class="flex-1">
                    <label class="block text-gray-300 font-semibold mb-2">Status wijzigen</label>
                    <select name="status" class="w-full p-2 rounded border border-gray-600 bg-gray-700 text-white">
                        <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">Update</button>
            </form>
        </div>
        @endif

        <div class="bg-gray-800 p-6 border border-gray-700 rounded-lg">
            <h4 class="font-bold text-lg text-white mb-4">Reacties van support</h4>
            
            @if($ticket->comments && count($ticket->comments) > 0)
                <div class="space-y-4 mb-6">
                    @foreach($ticket->comments as $comment)
                        <div class="bg-gray-700 p-4 rounded">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-semibold text-blue-400">{{ $comment->user->name }}</span>
                                <span class="text-gray-400 text-sm">{{ $comment->created_at->format('d-m-Y H:i') }}</span>
                            </div>
                            <p class="text-gray-200">{{ $comment->message }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 mb-6">Nog geen reacties van support.</p>
            @endif
        </div>
    </div>
</x-app-layout>