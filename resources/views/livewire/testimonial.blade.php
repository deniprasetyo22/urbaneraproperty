<div>
    {{-- HERO SECTION --}}
    <livewire:hero hero_quote="What Our Happy Residents Say" hero_title="Testimonials"
        hero_subTitle="Lorem ipsum, dolor sit amet consectetur adipisicing elit." />

    <section class="py-12 md:py-16">
        <div class="mx-auto max-w-7xl px-6">

            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">
                    Testimonials
                </h2>

                <div class="rounded-base shadow-xs flex">

                    {{-- x-data: Inisialisasi state open = false --}}
                    <div class="relative" x-data="{ open: false }">

                        {{-- Tombol Trigger --}}
                        <button @click="open = !open" type="button"
                            class="bg-brand hover:bg-brand-strong focus:ring-brand-medium shadow-xs rounded-base box-border flex items-center justify-around border border-transparent px-4 py-2 text-sm font-medium leading-5 text-white focus:outline-none focus:ring-4">

                            <i class="fa-solid fa-filter mr-2"></i> {{ $sort }}

                            {{-- Icon Rotate Logic --}}
                            <svg class="ms-1.5 h-4 w-4 transition-transform duration-200"
                                :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>

                        {{-- Dropdown Body --}}
                        <div x-show="open" @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95" style="display: none;"
                            class="rounded-base border-default-medium bg-neutral-primary-medium absolute right-0 z-20 mt-2 w-44 border shadow-lg">

                            <ul class="text-body p-2 text-sm font-medium">
                                @foreach (['Latest', 'Oldest', 'Highest', 'Lowest'] as $item)
                                    <li>
                                        {{-- Saat diklik: Panggil Livewire setSort, LALU tutup dropdown (open = false) --}}
                                        <button wire:click="setSort('{{ $item }}'); open = false"
                                            class="hover:bg-neutral-tertiary-medium hover:text-heading {{ $sort === $item ? 'bg-gray-100 font-bold' : '' }} block w-full rounded-md p-2 text-left">
                                            {{ $item === 'Highest' ? 'Highest Rating' : ($item === 'Lowest' ? 'Lowest Rating' : $item) }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <div class="flex items-center justify-center">
                <div class="my-24" wire:loading wire:target="search,setSort">
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

            <div wire:loading.remove wire:target="search,setSort">
                @if (count($testimonials) == 0)
                    <div class="flex flex-col items-center justify-center py-10">
                        <div class="rounded-full bg-gray-100 p-4">
                            <i class="fa-solid fa-comments text-3xl text-gray-400"></i>
                        </div>

                        <h2 class="text-xl font-semibold text-gray-800">
                            No Testimonials Yet
                        </h2>

                        <p class="mt-2 max-w-sm text-center text-sm text-gray-500">
                            We haven't added any client stories yet. Please check back later or be the first to share
                            your
                            experience!
                        </p>
                    </div>
                @else
                    <div class="grid gap-6 md:grid-cols-3">
                        @foreach ($testimonials as $testimonial)
                            <div class="relative rounded-xl bg-white p-8 text-center shadow">

                                {{-- 3 Dots Button (Alpine JS per Card) --}}
                                @if ($testimonial->video_link)
                                    {{-- Setiap kartu punya scope x-data sendiri --}}
                                    <div class="absolute right-4 top-4" x-data="{ open: false }">

                                        <button @click="open = !open"
                                            class="rounded-full p-1 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                            </svg>
                                        </button>

                                        {{-- Dropdown Menu --}}
                                        <div x-show="open" @click.outside="open = false" x-transition.origin.top.right
                                            style="display: none;"
                                            class="absolute right-0 z-10 mt-1 w-auto rounded-md border border-gray-200 bg-white shadow-md">

                                            <a href="{{ $testimonial->video_link }}"
                                                class="flex items-center justify-center gap-2 whitespace-nowrap px-2 py-1.5 text-gray-700 hover:bg-gray-100">
                                                <i class="fa-brands fa-youtube text-xl text-red-500"></i>
                                                <span class="text-xs">View on YouTube</span>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <img src="{{ asset($testimonial->avatar) }}" alt="{{ $testimonial->name }}"
                                    class="mx-auto mb-4 h-20 w-20 rounded-full object-cover">

                                <h3 class="text-base font-semibold">
                                    {{ $testimonial->name }}
                                </h3>

                                <p class="mb-4 text-sm text-gray-500">
                                    {{ $testimonial->residence->name }} –
                                    {{ Str::title($testimonial->residence->city) }}
                                </p>

                                <p class="text-sm italic">
                                    "{{ $testimonial->quote }}"
                                </p>

                                {{-- Rating --}}
                                <div class="mt-4 flex justify-center gap-1 text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="{{ $i <= $testimonial->rating ? 'fill-yellow-400' : 'fill-gray-300' }} h-4 w-4"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.385 2.46a1 1 0 00-.364 1.118l1.287 3.974c.3.921-.755 1.688-1.538 1.118l-3.385-2.46a1 1 0 00-1.175 0l-3.385 2.46c-.783.57-1.838-.197-1.538-1.118l1.287-3.974a1 1 0 00-.364-1.118L2.045 9.401c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.974z" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-10 flex justify-center">
                {{ $testimonials->links('livewire.custom-pagination') }}
            </div>
        </div>
    </section>
</div>
