<footer class="bg-gray-100 text-gray-600 border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

            <div>
                <h3 class="text-gray-900 text-xl font-bold mb-3">
                    {{ config('app.name', 'Ticket Flow') }}
                </h3>
                <p class="text-sm leading-relaxed">
                    Een modern ticketsysteem om support eenvoudig,
                    overzichtelijk en snel te beheren.
                </p>
            </div>

            <div>
                <h4 class="text-gray-900 font-semibold mb-4">Product</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Features</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Demo</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Updates</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-gray-900 font-semibold mb-4">Support</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Documentatie</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Contact</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Status</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-gray-900 font-semibold mb-4">Account</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 transition">Inloggen</a></li>
                    <li><a href="{{ route('register') }}" class="text-gray-600 hover:text-blue-600 transition">Registreren</a></li>
                </ul>
            </div>

        </div>

        <div class="border-t border-gray-200 mt-12 pt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-sm text-gray-500">
                © {{ date('Y') }} {{ config('app.name', 'Ticket Flow') }}. Alle rechten voorbehouden.
            </p>

            <div class="flex gap-4 text-gray-500">
                <a href="#" class="hover:text-blue-600 transition">
                    <i class="fa-brands fa-github"></i>
                </a>
                <a href="#" class="hover:text-blue-600 transition">
                    <i class="fa-brands fa-discord"></i>
                </a>
                <a href="#" class="hover:text-blue-600 transition">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
