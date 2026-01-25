@if ($paginator->hasPages())
    <div class="flex flex-col items-center gap-3">

        {{-- INFO --}}
        <span class="text-body block text-center text-xs">
            Showing
            <span class="text-heading font-semibold">
                {{ $paginator->firstItem() ?? 0 }}
            </span>
            to
            <span class="text-heading font-semibold">
                {{ $paginator->lastItem() ?? 0 }}
            </span>
            of
            <span class="text-heading font-semibold">
                {{ $paginator->total() }}
            </span>
            Entries
        </span>

        {{-- PAGINATION + PER PAGE --}}
        <nav aria-label="Page navigation example" class="flex flex-wrap items-center justify-center gap-4">

            <ul class="flex -space-x-px text-xs">

                {{-- Previous --}}
                <li>
                    @if ($paginator->onFirstPage())
                        <span
                            class="text-body bg-neutral-secondary-medium border-default-medium shadow-xs rounded-s-base flex h-8 items-center justify-center border px-3 text-xs font-medium leading-5 opacity-50">
                            <i class="fa-solid fa-angle-left"></i>
                        </span>
                    @else
                        <button wire:click="previousPage"
                            class="text-body bg-neutral-secondary-medium border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading shadow-xs rounded-s-base flex h-8 items-center justify-center border px-3 text-xs font-medium leading-5 focus:outline-none">
                            <i class="fa-solid fa-angle-left"></i>
                        </button>
                    @endif
                </li>

                {{-- Pages --}}
                @foreach ($elements as $element)
                    {{-- Dots --}}
                    @if (is_string($element))
                        <li>
                            <span
                                class="text-body bg-neutral-secondary-medium border-default-medium shadow-xs flex h-8 w-9 items-center justify-center border text-xs font-medium leading-5">
                                …
                            </span>
                        </li>
                    @endif

                    {{-- Page links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <li>
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page"
                                        class="text-fg-brand bg-neutral-tertiary-medium border-default-medium box-border flex h-8 w-9 items-center justify-center border text-xs font-medium focus:outline-none">
                                        {{ $page }}
                                    </span>
                                @else
                                    <button wire:click="gotoPage({{ $page }})"
                                        class="text-body bg-neutral-secondary-medium border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading shadow-xs flex h-8 w-9 items-center justify-center border text-xs font-medium leading-5 focus:outline-none">
                                        {{ $page }}
                                    </button>
                                @endif
                            </li>
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                <li>
                    @if ($paginator->hasMorePages())
                        <button wire:click="nextPage"
                            class="text-body bg-neutral-secondary-medium border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading shadow-xs rounded-e-base flex h-8 items-center justify-center border px-3 text-xs font-medium leading-5 focus:outline-none">
                            <i class="fa-solid fa-angle-right"></i>
                        </button>
                    @else
                        <span
                            class="text-body bg-neutral-secondary-medium border-default-medium shadow-xs rounded-e-base flex h-8 items-center justify-center border px-3 text-xs font-medium leading-5 opacity-50">
                            <i class="fa-solid fa-angle-right"></i>
                        </span>
                    @endif
                </li>

            </ul>

            {{-- PER PAGE --}}
            <div class="w-28">
                <select wire:model.live="perPage"
                    class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border px-3 py-2 text-xs leading-4">
                    <option value="9">9 per page</option>
                    <option value="18">18 per page</option>
                    <option value="27">27 per page</option>
                    <option value="36">36 per page</option>
                </select>
            </div>

        </nav>
    </div>
@endif
