<div>
    {{-- HERO SECTION --}}
    <livewire:hero hero_quote="Browse Our Resources" hero_title="Articles"
        hero_subTitle="Lorem ipsum, dolor sit amet consectetur adipisicing elit. Assumenda quibusdam voluptas ipsum, rem nihil dolorem necessitatibus placeat saepe. Sed, numquam! Atque doloremque asperiores dignissimos? Et." />

    <section class="py-12 md:py-16">
        <div class="mx-auto max-w-7xl px-6">

            <div class="mb-6 flex flex-col gap-4">
                <h2 class="text-xl font-semibold text-gray-800">Article List</h2>

                <div class="rounded-base shadow-xs flex">

                    <!-- SEARCH -->
                    <div class="relative w-full">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>

                        <input type="text" wire:model.live="search" placeholder="Search articles..."
                            class="bg-neutral-secondary-medium border-default-medium text-heading placeholder:text-body focus:border-brand focus:ring-brand rounded-l-base shadow-xs w-full border px-3 py-2.5 pl-10 text-sm focus:ring-1">
                    </div>

                    <!-- SORT -->
                    <div class="relative">
                        <button id="dropdown-sort-button" data-dropdown-toggle="sort" type="button"
                            class="rounded-r-base border-default-medium bg-brand hover:bg-brand-strong focus:ring-neutral-tertiary inline-flex h-full items-center justify-between border px-3 py-2.5 text-sm font-medium text-white focus:outline-none focus:ring-4">

                            <span class="truncate">
                                <i class="fa-solid fa-filter mr-1 sm:mr-2"></i> {{ $sort }}
                            </span>

                            <svg class="ms-1 h-4 w-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- DROPDOWN -->
                        <div id="sort"
                            class="rounded-base border-default-medium bg-neutral-primary-medium absolute right-0 z-20 mt-1 hidden w-44 border shadow-lg">
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
                            </ul>
                        </div>
                    </div>

                </div>

            </div>


            <!-- GRID -->
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
                @if (count($articles) == 0)
                    <div class="flex flex-col items-center justify-center py-16 text-center">
                        <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gray-100">
                            <i class="fa-solid fa-newspaper text-4xl text-gray-400"></i>
                        </div>

                        <h2 class="text-xl font-semibold text-gray-800">
                            No Articles Found
                        </h2>

                        <p class="mt-1 max-w-sm text-sm text-gray-500">
                            Try adjusting your search or filters.
                        </p>
                    </div>
                @else
                    <div class="grid gap-6 md:grid-cols-3">
                        @foreach ($articles as $article)
                            <div class="overflow-hidden rounded-xl shadow">
                                <img src="{{ $article->image }}" class="h-48 w-full object-cover md:h-56">
                                <div class="flex min-h-[220px] flex-col p-4 text-left">
                                    <h3 class="mb-auto text-xl font-semibold">{{ $article->title }}</h3>

                                    <p class="my-2 text-xs text-gray-600">
                                        <i class="fa-regular fa-calendar"></i>
                                        {{ $article->created_at->translatedFormat('l, j F Y H:i') }} WIB
                                    </p>

                                    <div class="line-clamp-3 text-sm text-gray-600">
                                        {!! $article->content !!}
                                    </div>

                                    <!-- LINK BAWAH -->
                                    <div class="pt-2 text-right">
                                        <a href="{{ route('article-detail', $article->slug) }}"
                                            class="text-sm text-blue-500 hover:text-blue-600">
                                            Learn more
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-10 flex justify-center">
                {{ $articles->links('livewire.custom-pagination') }}
            </div>

        </div>
    </section>
</div>
