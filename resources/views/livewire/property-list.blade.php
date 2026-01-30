<div x-data="{ showFilter: false }">
    {{-- HERO SECTION --}}
    <livewire:hero hero_quote="Explore and Browse Our" hero_title="Property Listing"
        hero_subTitle="Find your dream home with our curated list of properties." />

    <section class="py-12 md:py-16">
        <div class="mx-auto max-w-7xl px-6">

            <div class="mb-8 flex flex-col gap-4">
                <h2 class="text-xl font-semibold text-gray-800">Property List</h2>

                <div class="flex gap-3">
                    <div class="relative w-full">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="text-body h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" wire:model.live="search"
                            placeholder="Search property by name, location..."
                            class="bg-neutral-secondary-medium border-default-medium text-heading placeholder:text-body focus:border-brand focus:ring-brand rounded-base shadow-xs w-full border px-3 py-2.5 pl-10 text-sm focus:ring-1">
                    </div>

                    <button @click="showFilter = true" type="button"
                        class="bg-brand hover:bg-brand-strong border-brand focus:ring-brand rounded-base shadow-xs flex shrink-0 items-center gap-2 border px-4 py-2.5 text-sm font-medium text-white focus:outline-none focus:ring-2">
                        <i class="fa-solid fa-sliders"></i>
                        <span class="hidden sm:inline">Filters</span>
                    </button>
                </div>
            </div>

            {{-- SIDEBAR MODAL (OFF-CANVAS) --}}
            {{-- x-show mengontrol visibilitas seluruh wrapper modal --}}
            <div x-show="showFilter" style="display: none;" class="relative z-50" aria-labelledby="slide-over-title"
                role="dialog" aria-modal="true">

                <div x-show="showFilter" x-transition:enter="ease-in-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-black/30 backdrop-blur-sm transition-opacity" @click="showFilter = false">
                </div>

                <div class="pointer-events-none fixed inset-0 overflow-hidden">
                    <div class="absolute inset-0 overflow-hidden">
                        <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-24">

                            <div x-show="showFilter"
                                x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                                x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                                class="pointer-events-auto w-screen max-w-md">

                                <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">

                                    <div class="bg-brand p-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <h2 class="text-base font-semibold leading-6 text-white"
                                                id="slide-over-title">
                                                Filters & Sort
                                            </h2>
                                            <div class="ml-3 flex h-7 items-center">
                                                <button @click="showFilter = false" type="button"
                                                    class="relative rounded-md text-white hover:text-gray-200 focus:outline-none">
                                                    <span class="absolute -inset-2.5"></span>
                                                    <span class="sr-only">Close panel</span>
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="relative mt-6 flex-1 space-y-6 px-4 sm:px-6">

                                        <div>
                                            <label class="text-heading mb-2 block text-sm font-medium">Sort By</label>
                                            <select wire:model.live="sort"
                                                class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:border-brand focus:ring-brand w-full border px-3 py-2.5 text-sm">
                                                <option value="Latest">Latest</option>
                                                <option value="Oldest">Oldest</option>
                                                <option value="Highest">Highest Price</option>
                                                <option value="Lowest">Lowest Price</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="text-heading mb-2 block text-sm font-medium">Residence</label>
                                            <select wire:model.live="residence"
                                                class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:border-brand focus:ring-brand w-full border px-3 py-2.5 text-sm">
                                                <option value="">All Residences</option>
                                                @foreach ($this->residences as $residence)
                                                    <option value="{{ $residence }}">{{ $residence }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="text-heading mb-2 block text-sm font-medium">Location</label>
                                            <select wire:model.live="location"
                                                class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:border-brand focus:ring-brand w-full border px-3 py-2.5 text-sm">
                                                <option value="">All Locations</option>
                                                @foreach ($this->locations as $loc)
                                                    <option value="{{ $loc }}">{{ Str::title($loc) }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="text-heading mb-2 block text-sm font-medium">Property
                                                Type</label>
                                            <select wire:model.live="type"
                                                class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:border-brand focus:ring-brand w-full border px-3 py-2.5 text-sm">
                                                <option value="">All Types</option>
                                                @foreach ($this->types as $t)
                                                    <option value="{{ $t }}">{{ $t }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="text-heading mb-2 block text-sm font-medium">Status</label>
                                            <select wire:model.live="status"
                                                class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:border-brand focus:ring-brand w-full border px-3 py-2.5 text-sm">
                                                <option value="">All Status</option>
                                                @foreach ($this->statuses as $st)
                                                    <option value="{{ $st }}">{{ $st }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="text-heading mb-2 block text-sm font-medium">Price
                                                Range</label>
                                            <div class="space-y-2">
                                                <div class="flex items-center">
                                                    <input id="price-all" wire:model.live="priceRange" name="price"
                                                        type="radio" value=""
                                                        class="text-brand focus:ring-brand h-4 w-4 border-gray-300">
                                                    <label for="price-all"
                                                        class="ml-3 block text-sm font-medium text-gray-700">All
                                                        Price</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input id="price-u500" wire:model.live="priceRange"
                                                        name="price" type="radio" value="under_500"
                                                        class="text-brand focus:ring-brand h-4 w-4 border-gray-300">
                                                    <label for="price-u500"
                                                        class="ml-3 block text-sm font-medium text-gray-700">&lt; 500
                                                        M</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input id="price-500-1b" wire:model.live="priceRange"
                                                        name="price" type="radio" value="500_1b"
                                                        class="text-brand focus:ring-brand h-4 w-4 border-gray-300">
                                                    <label for="price-500-1b"
                                                        class="ml-3 block text-sm font-medium text-gray-700">500 M - 1
                                                        B</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input id="price-a1b" wire:model.live="priceRange" name="price"
                                                        type="radio" value="above_1b"
                                                        class="text-brand focus:ring-brand h-4 w-4 border-gray-300">
                                                    <label for="price-a1b"
                                                        class="ml-3 block text-sm font-medium text-gray-700">&gt; 1
                                                        B</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                                        <div class="flex gap-3">
                                            <button wire:click="resetFilters" type="button"
                                                @click="showFilter = false"
                                                class="rounded-base flex-1 border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                                                Reset
                                            </button>
                                            <button @click="showFilter = false" type="button"
                                                class="bg-brand hover:bg-brand-strong rounded-base flex-1 px-3 py-2 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                Show Results
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- END SIDEBAR --}}

            <div class="flex items-center justify-center">
                <div class="my-24" wire:loading wire:target="search,setSort,resetFilters">
                    <div role="status" class="flex flex-col items-center gap-3">
                        <svg aria-hidden="true" class="text-neutral-quaternary fill-brand h-10 w-10 animate-spin"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>

            <div wire:loading.remove
                wire:target="search,setSort,setPriceRange,setLocation,setType,setResidence,setStatus,page,resetFilters">
                @if (count($properties) == 0)
                    <div class="flex flex-col items-center justify-center py-10">
                        <div class="rounded-full bg-gray-100 p-4">
                            <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h2 class="mt-4 text-xl font-semibold text-gray-800">No Properties Found</h2>
                        <p class="text-gray-500">Try adjusting your search or filters.</p>
                        <button wire:click="resetFilters"
                            class="text-brand mt-4 text-sm font-medium hover:underline">Clear all filters</button>
                    </div>
                @else
                    <div class="grid gap-6 md:grid-cols-3">
                        @foreach ($properties as $property)
                            <div class="overflow-hidden rounded-xl shadow">
                                <div class="relative overflow-hidden">
                                    @if ($loop->index < 3 && $property->status === 'Available')
                                        <span
                                            class="absolute left-0 top-0 z-10 rounded-lg bg-green-500 px-4 py-1 text-sm text-white">
                                            New
                                        </span>
                                    @elseif ($property->status === 'Sold Out')
                                        <span
                                            class="absolute left-0 top-0 z-10 rounded-lg bg-red-500 px-4 py-1 text-sm text-white">
                                            Sold Out
                                        </span>
                                    @endif

                                    {{-- LOGIC PHP: Cek Tipe File (Video vs Image) --}}
                                    @php
                                        $firstMedia = null;
                                        $isVideo = false;
                                        $extension = '';

                                        // PERBAIKAN UTAMA: Gunakan 'media', bukan 'images'
                                        $rawGallery = $property->media;

                                        // 1. Normalisasi Data (Pastikan jadi Array)
                                        $gallery = [];
                                        if (is_array($rawGallery)) {
                                            $gallery = $rawGallery;
                                        } elseif (is_string($rawGallery)) {
                                            $decoded = json_decode($rawGallery, true);
                                            $gallery = is_array($decoded) ? $decoded : [$rawGallery];
                                        }

                                        // 2. Cari File Valid Pertama
                                        if (!empty($gallery)) {
                                            foreach ($gallery as $file) {
                                                if (!empty($file) && is_string($file)) {
                                                    $firstMedia = $file;
                                                    break;
                                                }
                                            }
                                        }

                                        // 3. Cek Ekstensi
                                        if ($firstMedia) {
                                            $extension = pathinfo($firstMedia, PATHINFO_EXTENSION);
                                            $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'webm']);
                                        }
                                    @endphp

                                    {{-- TAMPILAN MEDIA --}}
                                    @if ($firstMedia)
                                        @if ($isVideo)
                                            {{-- Tampilan Video (Autoplay loop) --}}
                                            <video class="h-full w-full object-cover" autoplay muted loop playsinline>
                                                <source src="{{ asset('storage/' . $firstMedia) }}"
                                                    type="video/{{ $extension }}">
                                            </video>
                                        @else
                                            {{-- Tampilan Gambar --}}
                                            <img src="{{ asset('storage/' . $firstMedia) }}"
                                                class="h-full w-full object-cover" alt="{{ $property->name }}">
                                        @endif
                                    @else
                                        {{-- Fallback jika tidak ada media --}}
                                        <div class="flex h-full w-full items-center justify-center text-gray-400">
                                            <div class="text-center">
                                                <i class="fa-regular fa-image mb-2 text-3xl"></i>
                                                <p class="text-xs">No Media</p>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                                <div class="space-y-1 p-4 text-left">
                                    <h3 class="font-semibold">{{ $property->name }}</h3>
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                            stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 21s-7-4.35-7-11a7 7 0 1114 0c0 6.65-7 11-7 11z" />
                                            <circle cx="12" cy="10" r="3" />
                                        </svg>
                                        <span>{{ Str::title(strtolower($property->residence->city)) }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        @if ($property->status === 'Available')
                                            <p class="font-bold">Rp. {{ number_format($property->price) }}</p>
                                        @elseif ($property->status === 'Sold Out')
                                            <p class="font-bold text-red-500">Sold Out</p>
                                        @endif
                                        <a href="{{ route('property-detail', $property->slug) }}"
                                            class="rounded-full border border-blue-600 px-2 py-1 text-sm text-blue-600 hover:bg-blue-600 hover:text-white">
                                            View details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-10 flex justify-center">
                {{ $properties->links('livewire.custom-pagination') }}
            </div>
        </div>
    </section>
</div>
