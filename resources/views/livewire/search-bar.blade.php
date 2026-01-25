{{-- SEARCH BAR WRAPPER --}}
<div class="absolute bottom-[-28px] left-1/2 z-20 w-full -translate-x-1/2 px-4">

    {{-- ================= MOBILE SEARCH ================= --}}
    <form wire:submit.prevent="search"
        class="relative mx-auto flex w-full max-w-md items-center gap-2 rounded-full bg-white p-2 shadow-lg ring-1 ring-gray-200 sm:hidden">

        {{-- HAMBURGER --}}
        <button type="button" wire:click="$toggle('showFilterMenu')"
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-gray-200 hover:bg-gray-100">
            <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M3 12h18M3 20h18" />
            </svg>
        </button>

        {{-- FILTER MENU --}}
        @if ($showFilterMenu)
            <div
                class="absolute left-0 top-14 z-40 w-44 overflow-hidden rounded-xl bg-white shadow-lg ring-1 ring-gray-200">

                <button type="button" wire:click="selectFilter('location')"
                    class="{{ $activeFilter === 'location' ? 'bg-gray-100 font-medium' : '' }} block w-full px-4 py-2 text-left text-sm hover:bg-gray-100">
                    Location
                </button>

                <button type="button" wire:click="selectFilter('type')"
                    class="{{ $activeFilter === 'type' ? 'bg-gray-100 font-medium' : '' }} block w-full px-4 py-2 text-left text-sm hover:bg-gray-100">
                    Property Type
                </button>

                <button type="button" wire:click="selectFilter('priceRange')"
                    class="{{ $activeFilter === 'priceRange' ? 'bg-gray-100 font-medium' : '' }} block w-full px-4 py-2 text-left text-sm hover:bg-gray-100">
                    Price Range
                </button>
            </div>
        @endif

        {{-- DYNAMIC INPUT --}}
        <div class="relative flex flex-1 items-center">
            @if ($activeFilter === 'location')
                {{-- TAMBAHKAN wire:key="location-input" --}}
                <div class="relative flex flex-1 items-center" wire:key="location-input">

                    {{-- ICON --}}
                    <svg class="absolute left-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                        stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 21s-7-4.35-7-11a7 7 0 1114 0c0 6.65-7 11-7 11z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>

                    {{-- SELECT LOCATION --}}
                    <select wire:model.defer="location"
                        class="w-full appearance-none rounded-full border border-gray-200 py-2.5 pl-10 pr-4 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="" selected disabled hidden>Location</option>
                        @foreach ($locations as $city)
                            <option value="{{ $city }}">{{ Str::title($city) }}</option>
                        @endforeach
                    </select>

                </div>
            @elseif ($activeFilter === 'type')
                {{-- TAMBAHKAN wire:key="type-input" --}}
                <div class="relative w-full" wire:key="type-input">

                    {{-- ICON TYPE --}}
                    <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none"
                        stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 9.75L12 4l9 5.75v9.5A1.75 1.75 0 0119.25 21H4.75A1.75 1.75 0 013 19.25v-9.5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V12h6v9" />
                    </svg>

                    {{-- SELECT TYPE --}}
                    <select wire:model.defer="type"
                        class="w-full appearance-none rounded-full border border-gray-200 py-2.5 pl-10 pr-10 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="" selected disabled hidden>Property Type</option>
                        @foreach ($types as $item)
                            <option value="{{ $item }}">{{ Str::title($item) }}</option>
                        @endforeach
                    </select>

                </div>
            @elseif ($activeFilter === 'priceRange')
                {{-- TAMBAHKAN wire:key="price-input" --}}
                <div class="relative w-full" wire:key="price-input">

                    {{-- ICON PRICE --}}
                    <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>

                    {{-- SELECT PRICE --}}
                    <select wire:model.defer="priceRange"
                        class="w-full appearance-none rounded-full border border-gray-200 py-2.5 pl-10 pr-10 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="" selected disabled hidden>Price Range</option>
                        <option value="under_500">&lt; 500 jt</option>
                        <option value="500_1b">500 jt – 1 M</option>
                        <option value="above_1b">&gt; 1 M</option>
                    </select>

                </div>
            @endif
        </div>

        {{-- SEARCH BUTTON --}}
        <div>
            <button type="submit"
                class="flex shrink-0 items-center gap-2 rounded-full bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700">

                {{-- ICON SEARCH --}}
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197
                 m0 0A7.5 7.5 0 1 0 5.196 5.196
                 a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>

                Find
            </button>
        </div>
    </form>

    {{-- ================= DESKTOP SEARCH ================= --}}
    <form wire:submit.prevent="search"
        class="mx-auto hidden w-full max-w-5xl items-center gap-3 rounded-full bg-white p-2 shadow-lg ring-1 ring-gray-200 sm:flex">

        {{-- LOCATION --}}
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none"
                stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 21s-7-4.35-7-11a7 7 0 1114 0c0 6.65-7 11-7 11z" />
                <circle cx="12" cy="10" r="3" />
            </svg>

            <select wire:model.defer="location"
                class="w-full appearance-none rounded-full border border-gray-200 py-2.5 pl-10 pr-10 text-sm">

                <option value="" selected disabled hidden>Location</option>

                @foreach ($locations as $city)
                    <option value="{{ $city }}">{{ Str::title($city) }}</option>
                @endforeach

            </select>


        </div>

        {{-- PROPERTY TYPE --}}
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none"
                stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
            </svg>

            <select wire:model.defer="type"
                class="w-full appearance-none rounded-full border border-gray-200 py-2.5 pl-10 pr-10 text-sm">
                <option value="" selected disabled hidden>Property Type</option>
                @foreach ($types as $type)
                    <option value="{{ $type }}">{{ Str::title($type) }}</option>
                @endforeach
            </select>

        </div>

        {{-- PRICERange --}}
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>

            <select wire:model.defer="priceRange"
                class="w-full appearance-none rounded-full border border-gray-200 py-2.5 pl-10 pr-10 text-sm">

                <option value="" selected disabled hidden>Price Range</option>
                <option value="under_500">&lt; 500 jt</option>
                <option value="500_1b">500 jt – 1 M</option>
                <option value="above_1b">&gt; 1 M</option>

            </select>
        </div>


        {{-- BUTTON --}}
        <button type="submit"
            class="flex flex-none items-center gap-2 rounded-full bg-blue-600 px-6 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700">

            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>

            Find Property
        </button>
    </form>

</div>
