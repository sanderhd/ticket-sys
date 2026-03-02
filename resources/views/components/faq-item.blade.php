@props(['question', 'answer'])

<div
    x-data="{ open: false }"
    class="border border-gray-200 rounded-lg overflow-hidden"
>
    <button
        @click="open = !open"
        class="w-full flex justify-between items-center px-6 py-4 text-left text-gray-900 font-medium hover:bg-gray-50 transition"
    >
        <span>{{ $question }}</span>
        <i
            class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-200"
            :class="{ 'rotate-180': open }"
        ></i>
    </button>

    <div
        x-show="open"
        x-transition
        class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100"
    >
        <p class="pt-4">{{ $answer }}</p>
    </div>
</div>