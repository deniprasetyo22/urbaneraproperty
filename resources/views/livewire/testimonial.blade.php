<div>
    {{-- HERO SECTION --}}
    <livewire:hero hero_quote="What Our Happy Residents Say" hero_title="Testimonials"
        hero_subTitle="Lorem ipsum, dolor sit amet consectetur adipisicing elit. Assumenda quibusdam voluptas ipsum, rem nihil dolorem necessitatibus placeat saepe. Sed, numquam! Atque doloremque asperiores dignissimos? Et." />

    <section class="py-12 md:py-16">
        <div class="mx-auto max-w-7xl px-6">

            <div class="mb-6 flex items-center justify-between">
                <!-- TITLE -->
                <h2 class="text-xl font-semibold text-gray-800">
                    Testimonials
                </h2>

                <!-- SORT -->
                <div class="rounded-base shadow-xs flex">

                    <!-- SORT DROPDOWN -->
                    <div class="relative">
                        <button id="dropdown-button" data-dropdown-toggle="sort" type="button"
                            class="bg-brand hover:bg-brand-strong focus:ring-brand-medium shadow-xs rounded-base box-border flex items-center justify-around border border-transparent px-4 py-2 text-sm font-medium leading-5 text-white focus:outline-none focus:ring-4">

                            <i class="fa-solid fa-filter mr-2"></i> {{ $sort }}

                            <svg class="ms-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- DROPDOWN MENU -->
                        <div id="sort"
                            class="rounded-base border-default-medium bg-neutral-primary-medium absolute right-0 z-10 mt-2 hidden w-44 border shadow-lg">
                            <ul class="text-body p-2 text-sm font-medium">
                                <li>
                                    <button wire:click="setSort('Latest')"
                                        class="hover:bg-neutral-tertiary-medium hover:text-heading block w-full rounded-md p-2 text-left">
                                        Latest
                                    </button>
                                </li>
                                <li>
                                    <button wire:click="setSort('Oldest')"
                                        class="hover:bg-neutral-tertiary-medium hover:text-heading block w-full rounded-md p-2 text-left">
                                        Oldest
                                    </button>
                                </li>
                                <li>
                                    <button wire:click="setSort('Highest')"
                                        class="hover:bg-neutral-tertiary-medium hover:text-heading block w-full rounded-md p-2 text-left">
                                        Highest Rating
                                    </button>
                                </li>
                                <li>
                                    <button wire:click="setSort('Lowest')"
                                        class="hover:bg-neutral-tertiary-medium hover:text-heading block w-full rounded-md p-2 text-left">
                                        Lowest Rating
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>


            <!-- GRID -->
            @if (count($testimonials) == 0)
                <div class="flex flex-col items-center justify-center py-10">
                    <div class="rounded-full bg-gray-100 p-4">
                        <i class="fa-solid fa-comments text-3xl text-gray-400"></i>
                    </div>

                    <h2 class="text-xl font-semibold text-gray-800">
                        No Testimonials Yet
                    </h2>

                    <p class="mt-2 max-w-sm text-center text-sm text-gray-500">
                        We haven't added any client stories yet. Please check back later or be the first to share your
                        experience!
                    </p>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($testimonials as $testimonial)
                        <div class="rounded-xl bg-white p-8 text-center shadow">
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
            <div class="mt-10 flex justify-center">
                {{ $testimonials->links('livewire.custom-pagination') }}
            </div>
        </div>
    </section>
</div>
