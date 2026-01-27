<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl text-white font-semibold">Ticket #{{ $ticket->id }} | {{ $ticket->title }}</h2>
            <button onclick="window.location='{{ route('tickets.index') }}'" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Mijn tickets</button>
        </div>
    </x-slot>

    <div class="p-6 space-y-6">
        <div class="bg-white p-6 border border-gray-300 rounded-lg">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="font-bold text-2xl text-gray-900">{{ $ticket->title }}</h3>
                    <p class="text-gray-600 text-sm mt-1">Aangemaakt: {{ $ticket->created_at->format('d-m-Y H:i') }}</p>
                </div>
                <span class="px-4 py-2 rounded-full text-white font-semibold text-sm
                    @if($ticket->status === 'open') bg-blue-600
                    @elseif($ticket->status === 'in_progress') bg-yellow-600
                    @elseif($ticket->status === 'closed') bg-green-600
                    @else bg-gray-600 @endif">
                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                </span>
            </div>
            <p class="text-gray-800 leading-relaxed">{{ $ticket->description }}</p>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="bg-white p-6 border border-gray-300 rounded-lg">
            <h4 class="font-bold text-lg text-gray-900 mb-4">Admin</h4>
            <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="flex gap-4 items-end">
                @csrf
                @method('PATCH')
                
                <div class="flex-1">
                    <label class="block text-gray-700 font-semibold mb-2">Status wijzigen</label>
                    <select name="status" class="w-full p-2 rounded border border-gray-300 bg-white text-gray-900">
                        <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Update</button>
            </form>
        </div>
        @endif

        <div class="bg-white p-6 border border-gray-300 rounded-lg mt-6">
            <h4 class="font-bold text-lg text-gray-900 mb-4">Reacties</h4>
            
            @foreach($ticket->comments as $comment)
                <div class="mb-2 p-2 bg-gray-100 rounded">
                    <strong>{{ $comment->user->name }}</strong>
                    <p>{{ $comment->body }}</p>
                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
            @endforeach

            @auth
            <form action="{{ route('comments.store', $ticket) }}" method="POST" class="mt-4">
                @csrf
                <textarea name="body" rows="3" class="w-full border rounded p-2" placeholder="Voeg een reactie toe..."></textarea>
                <x-input-error :messages="$errors->get('body')" class="mt-1" />
                <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">Plaatsen</button>
            </form>
            @endauth
        </div>
    </div>
</x-app-layout>