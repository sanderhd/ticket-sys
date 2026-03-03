<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl text-gray-900 font-semibold">Ticket #{{ $ticket->id }} | {{ $ticket->title }}</h2>
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
            @if(auth()->check() && auth()->id() === $ticket->user_id)
                @if(!$ticket->closure_requested && $ticket->status !== 'closed')
                    <form action="{{ route('tickets.requestClosure', $ticket) }}" method="POST" class="mb-4">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">Sluiting aanvragen</button>
                    </form>
                @elseif($ticket->closure_requested)
                    <div class="mb-4 p-3 rounded bg-yellow-50 border border-yellow-200 text-yellow-700">
                        Sluiting aangevraagd. Een beheerder zal dit controleren.
                    </div>
                @endif
            @endif
            @if(auth()->user()->isPro())
                <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="mb-4">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="priority" class="block text-sm font-medium text-gray-700">Prioriteit</label>
                        <select name="priority" class="w-full p-2 rounded border border-gray-300 bg-white text-gray-900">
                            <option value="low" {{ $ticket->priority === 'low' ? 'selected' : '' }}>Laag</option>
                            <option value="medium" {{ $ticket->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $ticket->priority === 'high' ? 'selected' : '' }}>Hoog</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="labels" class="block text-sm font-medium text-gray-700">Labels</label>
                        <input type="text" name="labels" value="{{ $ticket->labels }}" class="w-full p-2 rounded border border-gray-300 bg-white text-gray-900" placeholder="Labels (komma gescheiden)">
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Opslaan</button>
                </form>
            @endif
            <p class="text-gray-800 leading-relaxed">{{ $ticket->description }}</p>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="bg-white p-6 border border-gray-300 rounded-lg">
            <h4 class="font-bold text-lg text-gray-900 mb-4">Admin</h4>
            <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Status wijzigen</label>
                    <select name="status" class="w-full p-2 rounded border border-gray-300 bg-white text-gray-900">
                        <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Prioriteit</label>
                    <select name="priority" class="w-full p-2 rounded border border-gray-300 bg-white text-gray-900">
                        <option value="" {{ !$ticket->priority ? 'selected' : '' }}>Geen</option>
                        <option value="low" {{ $ticket->priority === 'low' ? 'selected' : '' }}>Laag</option>
                        <option value="medium" {{ $ticket->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ $ticket->priority === 'high' ? 'selected' : '' }}>Hoog</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Labels</label>
                    <input type="text" name="labels" value="{{ $ticket->labels }}" class="w-full p-2 rounded border border-gray-300 bg-white text-gray-900" placeholder="Labels (komma gescheiden)">
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Update</button>
            </form>

            @if($ticket->closure_requested)
                <div class="mt-4 p-4 rounded bg-yellow-50 border border-yellow-200">
                    <p class="font-semibold text-yellow-700">Sluitingsverzoek ontvangen</p>
                    <p class="text-sm text-gray-700 mt-2">De eigenaar heeft gevraagd om dit ticket te sluiten. Kies hieronder om te sluiten of het verzoek af te wijzen.</p>

                    <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <form action="{{ route('tickets.handleClosure', $ticket) }}" method="POST" class="space-y-2">
                            @csrf
                            <input type="hidden" name="action" value="approve">
                            <label class="block text-sm font-medium text-gray-700">Reden (optioneel)</label>
                            <textarea name="reason" rows="3" class="w-full p-2 border border-gray-300 rounded"></textarea>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">Sluit ticket (goedkeuren)</button>
                        </form>

                        <form action="{{ route('tickets.handleClosure', $ticket) }}" method="POST" class="space-y-2">
                            @csrf
                            <input type="hidden" name="action" value="decline">
                            <label class="block text-sm font-medium text-gray-700">Optioneel bericht</label>
                            <textarea name="reason" rows="3" class="w-full p-2 border border-gray-300 rounded"></textarea>
                            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">Weiger verzoek</button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="mt-4 border-t pt-4">
                <h5 class="font-semibold mb-2">Direct sluiten</h5>
                <form action="{{ route('tickets.handleClosure', $ticket) }}" method="POST" class="space-y-2">
                    @csrf
                    <input type="hidden" name="action" value="close">
                    <label class="block text-sm font-medium text-gray-700">Reden voor sluiten (verplicht bij sluiten)</label>
                    <textarea name="reason" rows="3" required class="w-full p-2 border border-gray-300 rounded"></textarea>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">Sluit ticket</button>
                </form>
            </div>
        </div>
        @endif

        <div class="bg-white p-6 border border-gray-300 rounded-lg mt-6">
            <h4 class="font-bold text-lg text-gray-900 mb-6">Reacties</h4>

            @if($ticket->comments->isEmpty())
                <p class="text-sm text-gray-400 text-center py-6">Nog geen reacties. Wees de eerste!</p>
            @else
                <div class="space-y-4 mb-6">
                    @foreach($ticket->comments as $comment)
                        @php
                            $isOwn = auth()->check() && auth()->id() === $comment->user_id;
                            $initials = collect(explode(' ', $comment->user->name))
                                ->map(fn($w) => strtoupper($w[0]))
                                ->take(2)
                                ->implode('');
                            $colors = ['bg-purple-500','bg-blue-500','bg-green-500','bg-pink-500','bg-orange-500','bg-teal-500'];
                            $color = $colors[$comment->user_id % count($colors)];
                        @endphp
                        <div class="flex gap-4 {{ $isOwn ? 'flex-row-reverse' : '' }}">
                            <div class="h-9 w-9 rounded-full {{ $color }} flex items-center justify-center text-white text-xs font-bold shrink-0">
                                {{ $initials }}
                            </div>
                            <div class="max-w-[75%] {{ $isOwn ? 'items-end' : 'items-start' }} flex flex-col">
                                <div class="{{ $isOwn ? 'bg-blue-50 border border-blue-200' : 'bg-gray-50 border border-gray-200' }} rounded-lg px-4 py-3">
                                    <div class="flex items-center gap-2 mb-1 {{ $isOwn ? 'flex-row-reverse' : '' }}">
                                        <span class="text-sm font-semibold text-gray-800">
                                            {{ $comment->user->name }}
                                            @if($isOwn)
                                                <span class="text-xs text-blue-500 font-normal ml-1">(jij)</span>
                                            @endif
                                        </span>
                                        <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $comment->body }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @auth
                @if($ticket->status !== 'closed')
                    <form action="{{ route('comments.store', $ticket) }}" method="POST">
                        @csrf
                        <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                            <textarea
                                name="body"
                                rows="3"
                                class="w-full text-sm text-gray-800 bg-transparent resize-none outline-none placeholder-gray-400"
                                placeholder="Schrijf een reactie..."></textarea>
                            <x-input-error :messages="$errors->get('body')" class="mt-1" />
                            <div class="flex justify-end mt-2">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded transition">
                                    Verstuur reactie
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="rounded p-4 bg-gray-50 border border-gray-200 text-gray-700">Dit ticket is gesloten — de chat is geblokkeerd.</div>
                @endif
            @endauth

            @if($ticket->status === 'closed' && $ticket->closed_reason)
                <div class="mt-4 p-3 rounded bg-green-50 border border-green-200 text-green-700">
                    <strong>Reden voor sluiting:</strong>
                    <p class="mt-1 text-sm">{{ $ticket->closed_reason }}</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>