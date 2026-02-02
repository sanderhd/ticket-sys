<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Mijn Dashboard</h2>
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
