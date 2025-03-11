<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Widget content --}}

        <div>
            <div class="relative">
                <button class="flex items-center space-x-2">
                    <span>{{ strtoupper(app()->getLocale()) }}</span>
                    <x-heroicon-o-chevron-down class="w-4 h-4" />
                </button>
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg">
                    <a href="{{ route('language.switch', ['locale' => 'si']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        සිංහල
                    </a>
                    <a href="{{ route('language.switch', ['locale' => 'ta']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        தமிழ்
                    </a>
                    <a href="{{ route('language.switch', ['locale' => 'en']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        English
                    </a>
                </div>
            </div>
        </div>

    </x-filament::section>
</x-filament-widgets::widget>
