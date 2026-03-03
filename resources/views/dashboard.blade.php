<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">{{ auth()->user()->isAdmin() ? 'Admin Dashboard' : 'Mijn Dashboard' }}</h2>
            <button onclick="window.location='{{ route('tickets.index') }}'" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Mijn tickets</button>
        </div>
    </x-slot>

    <div class="py-12">
        @php 
            $labels = $stats?->keys() ?? collect();
            $data = $stats?->values() ?? collect();
        @endphp

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Mijn tickets</h3>
                        <canvas id="ticketChart" style="max-height: 250px;"></canvas>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Recente tickets</h3>
                        <div class="space-y-4">
                            @forelse(($recentTickets ?? collect())->take(3) as $ticket)
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <p class="font-medium text-gray-900">{{ $ticket->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $ticket->created_at?->diffForHumans() }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500">Er zijn momenteel geen recente tickets.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->isAdmin())
    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Alle tickets</h3>

            @forelse($allTickets ?? collect() as $ticket)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-4" x-data="{ open: false }">
                <div class="p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                                {{ $ticket->status === 'open'        ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $ticket->status === 'in_progress'  ? 'bg-blue-100 text-blue-800'   : '' }}
                                {{ $ticket->status === 'closed'       ? 'bg-green-100 text-green-800' : '' }}
                                {{ !in_array($ticket->status, ['open','in_progress','closed']) ? 'bg-gray-100 text-gray-600' : '' }}
                            ">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status ?? 'open')) }}
                            </span>

                            @if($ticket->priority)
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $ticket->priority === 'high'   ? 'bg-red-100 text-red-700'    : '' }}
                                {{ $ticket->priority === 'medium' ? 'bg-orange-100 text-orange-700' : '' }}
                                {{ $ticket->priority === 'low'    ? 'bg-gray-100 text-gray-600'  : '' }}
                            ">{{ ucfirst($ticket->priority) }}</span>
                            @endif

                            @if($ticket->labels)
                                @foreach(explode(',', $ticket->labels) as $label)
                                <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full">{{ trim($label) }}</span>
                                @endforeach
                            @endif
                        </div>

                        <a href="{{ route('tickets.show', $ticket) }}" class="font-semibold text-gray-900 hover:text-blue-600 truncate block">
                            #{{ $ticket->id }} — {{ $ticket->title }}
                        </a>
                        <p class="text-xs text-gray-400 mt-0.5">Door {{ $ticket->user->name }} &middot; {{ $ticket->created_at->diffForHumans() }}</p>
                    </div>

                    <button @click="open = !open"
                        class="flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 font-medium shrink-0">
                        <span x-text="open ? 'Verberg' : 'Reacties'"></span>
                        <span class="text-xs bg-blue-100 text-blue-700 rounded-full px-2 py-0.5">{{ $ticket->comments->count() }}</span>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>

                <div x-show="open" x-cloak class="border-t border-gray-100 px-5 py-4 space-y-3 bg-gray-50 rounded-b-lg">
                    @forelse($ticket->comments as $comment)
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-semibold text-gray-700">{{ $comment->user->name }}
                                <span class="font-normal text-gray-400 ml-1">{{ $comment->created_at->diffForHumans() }}</span>
                            </p>
                            <p class="text-sm text-gray-800 mt-0.5">{{ $comment->body }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400">Nog geen reacties.</p>
                    @endforelse

                    <form action="{{ route('comments.store', $ticket) }}" method="POST" class="pt-2">
                        @csrf
                        <div class="flex gap-2">
                            <input type="text" name="body" required placeholder="Schrijf een reactie..."
                                class="flex-1 text-sm border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded">
                                Stuur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-gray-500">Er zijn nog geen tickets.</p>
            @endforelse
        </div>
    </div>
    @endif
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('ticketChart').getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($labels),
            datasets: [{
                data: @json($data),
                backgroundColor: ['#facc15', '#3b82f6', '#22c55e'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
