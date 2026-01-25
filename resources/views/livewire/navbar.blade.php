<nav class="fixed inset-x-0 top-6 z-50">
    <div class="mx-auto px-4">

        {{-- MAIN BAR --}}
        <div
            class="flex items-center justify-between rounded-full border border-gray-200 bg-white/90 px-5 py-3 shadow-md backdrop-blur">

            {{-- LOGO --}}
            <a href="/" class="flex items-center gap-2">
                <img src={{ asset('images/logo.png') }} alt="logo" class="h-8 w-auto">
            </a>

            {{-- DESKTOP MENU --}}
            <div class="relative hidden items-center gap-8 text-sm font-medium md:flex">
                <a href="/"
                    class="{{ request()->routeIs('home') ? 'text-brand' : 'text-gray-700 hover:text-brand' }} rounded-full px-3 py-1.5 transition">
                    Home
                </a>

                {{-- COMPANY --}}
                <div class="relative">
                    <button wire:click="toggleCompany"
                        class="{{ request()->routeIs('residence-list', 'property-list', 'article-list', 'testimonials', 'customer-feedback')
                            ? 'text-brand'
                            : 'text-gray-700 hover:text-blue-600' }} flex items-center gap-1">
                        Company
                        <svg class="{{ $companyOpen ? 'rotate-180' : '' }} h-4 w-4 transition-transform duration-200"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- DROPDOWN --}}
                    <div
                        class="{{ $companyOpen
                            ? 'opacity-100 translate-y-0 scale-100'
                            : 'opacity-0 -translate-y-2 scale-95 pointer-events-none' }} absolute mt-3 w-44 origin-top overflow-hidden rounded-xl border bg-white shadow-lg transition-all duration-300">

                        @php
                            $dropdownClass = 'block px-4 py-2 text-sm transition';
                            $activeClass = 'bg-brand text-white font-semibold';
                            $inactiveClass = 'text-gray-700 hover:bg-gray-100 hover:text-brand';
                        @endphp

                        <a href="{{ route('residence-list') }}"
                            class="{{ $dropdownClass }} {{ request()->routeIs('residence-list') ? $activeClass : $inactiveClass }}">
                            Residences
                        </a>

                        <a href="{{ route('property-list') }}"
                            class="{{ $dropdownClass }} {{ request()->routeIs('property-list') ? $activeClass : $inactiveClass }}">
                            Properties
                        </a>

                        <a href="{{ route('article-list') }}"
                            class="{{ $dropdownClass }} {{ request()->routeIs('article-list') ? $activeClass : $inactiveClass }}">
                            Articles
                        </a>

                        <a href="{{ route('testimonials') }}"
                            class="{{ $dropdownClass }} {{ request()->routeIs('testimonials') ? $activeClass : $inactiveClass }}">
                            Testimonials
                        </a>

                        <a href="{{ route('customer-feedback') }}"
                            class="{{ $dropdownClass }} {{ request()->routeIs('customer-feedback') ? $activeClass : $inactiveClass }}">
                            Customer Feedback
                        </a>
                    </div>

                </div>

                <a href="{{ route('about') }}"
                    class="{{ request()->routeIs('about') ? 'text-brand' : 'text-gray-700 hover:text-blue-600' }}">
                    About Us
                </a>
            </div>

            {{-- DESKTOP CTA --}}
            <a href="{{ route('contact') }}"
                class="hidden rounded-full bg-blue-600 px-5 py-2 text-sm font-medium text-white transition hover:bg-blue-700 hover:opacity-90 md:inline-block">
                Contact Us
            </a>

            {{-- MOBILE TOGGLE --}}
            <button wire:click="toggleMobile"
                class="flex h-10 w-10 items-center justify-center rounded-full hover:bg-gray-100 md:hidden">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        {{-- MOBILE MENU --}}
        <div
            class="{{ $mobileOpen
                ? 'opacity-100 translate-y-0 scale-100'
                : 'opacity-0 -translate-y-4 scale-95 pointer-events-none' }} z-40 mt-3 origin-top overflow-hidden rounded-2xl border border-gray-200 bg-white/95 shadow-md backdrop-blur transition-all duration-300 md:hidden">

            <a href="/"
                class="{{ request()->routeIs('home') ? 'bg-brand text-white' : 'hover:bg-gray-100' }} block px-6 py-4">
                Home
            </a>

            {{-- MOBILE COMPANY --}}
            <button wire:click="toggleMobileCompany" class="flex w-full items-center justify-between px-6 py-4">
                <span>Company</span>
                <svg class="{{ $mobileCompanyOpen ? 'rotate-180' : '' }} h-4 w-4 transition-transform duration-200"
                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div
                class="{{ $mobileCompanyOpen ? 'max-h-50 opacity-100' : 'max-h-0 opacity-0' }} w-full overflow-hidden bg-gray-50 px-6 transition-all duration-300">

                <a href="{{ route('residence-list') }}"
                    class="{{ request()->routeIs('residence-list') ? 'bg-brand text-white' : 'hover:bg-gray-100' }} block px-4 py-2">
                    Residences
                </a>

                <a href="{{ route('property-list') }}"
                    class="{{ request()->routeIs('property-list') ? 'bg-brand text-white' : 'hover:bg-gray-100' }} block px-4 py-2">
                    Properties
                </a>

                <a href="{{ route('article-list') }}"
                    class="{{ request()->routeIs('article-list') ? 'bg-brand text-white' : 'hover:bg-gray-100' }} block px-4 py-2">
                    Articles
                </a>

                <a href="{{ route('testimonials') }}"
                    class="{{ request()->routeIs('testimonials') ? 'bg-brand text-white' : 'hover:bg-gray-100' }} block px-4 py-2">
                    Testimonials
                </a>

                <a href="{{ route('customer-feedback') }}"
                    class="{{ request()->routeIs('customer-feedback') ? 'bg-brand text-white' : 'hover:bg-gray-100' }} block px-4 py-2">
                    Customer Feedback
                </a>
            </div>

            <a href="{{ route('about') }}"
                class="{{ request()->routeIs('about') ? 'bg-brand text-white' : 'hover:bg-gray-100' }} block px-6 py-4">
                About Us
            </a>

            <div class="px-6 py-4">
                <a href="{{ route('contact') }}" class="bg-brand block rounded-full py-2 text-center text-white">
                    Contact Us
                </a>
            </div>
        </div>

    </div>
</nav>
