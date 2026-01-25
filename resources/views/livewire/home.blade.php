<div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 2000)">

    {{-- START: LOADING SCREEN --}}
    <div x-show="loading" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-[9999] flex items-center justify-center bg-white">

        {{-- Logo dengan animasi Pulse --}}
        <img src="{{ asset('images/logo.png') }}" alt="Loading..." class="h-8 w-auto animate-pulse object-contain md:h-12">

    </div>
    {{-- END: LOADING SCREEN --}}
    {{-- HERO SECTION --}}

    <section class="relative">

        {{-- HERO WRAPPER --}}
        <div class="relative h-[650px] bg-cover bg-center"
            style="background-image:url('{{ asset('images/banner.webp') }}')">

            {{-- NAVBAR (HARUS PALING ATAS) --}}
            <div class="relative z-30">
                <livewire:navbar />
            </div>

            {{-- OVERLAY (DI BAWAH NAVBAR) --}}
            <div class="absolute inset-0 z-10 bg-black/40"></div>

            {{-- HERO CONTENT --}}
            <div class="relative z-20 flex h-full items-center">
                <div class="mx-auto max-w-4xl px-6 text-center text-white">
                    <h1 class="mb-4 text-4xl font-bold md:text-5xl">
                        Where Nature and Living<br>Grow Together
                    </h1>

                    <p class="mb-8 text-sm text-gray-200 md:text-base">
                        A home is more than just a place to live, it is a living space in harmony with nature
                    </p>

                    <div class="flex justify-center gap-4">
                        <a href="{{ route('property-list') }}"
                            class="rounded-full bg-blue-600 px-6 py-3 text-sm hover:bg-blue-700">
                            Browse Properties
                        </a>
                        <button wire:click="toggleModalVideo"
                            class="rounded-full border border-white bg-white/20 px-6 py-3 text-sm hover:bg-white/30">
                            ▶ Watch Video
                        </button>
                    </div>
                </div>
            </div>

            @if ($showVideo)
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">

                    <!-- backdrop -->
                    <div class="absolute inset-0" wire:click="toggleModalVideo"></div>

                    <div class="relative z-10 w-full max-w-5xl px-4">

                        <!-- WRAPPER GAMBAR -->
                        <div class="relative w-full rounded-md">

                            <!-- Close button (nempel ke gambar) -->
                            <button wire:click="toggleModalVideo"
                                class="absolute right-0 top-0 z-20 flex h-9 w-9 items-center justify-center rounded-full bg-gray-200 text-gray-800 shadow hover:bg-gray-300">
                                ✕
                            </button>

                            {{-- VIDEO --}}
                            <video class="w-full rounded-md" controls autoplay loop>
                                <source src="{{ asset($company_profile->video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                        </div>
                    </div>
                </div>
            @endif

            {{-- SEARCH BAR --}}
            <livewire:search-bar />

        </div>
    </section>


    {{-- FEATURED LISTING --}}
    <section class="scroll-animate mx-auto mt-14 max-w-7xl px-6 text-center md:mt-16">
        <h2 class="mb-2 text-2xl font-bold">
            Find Your Dream Home in
            <br>
            Our <span class="font-secondary italic text-blue-600">Featured Listings</span>
        </h2>

        @if (count($residences) == 0)
            <div class="flex flex-col items-center justify-center py-10">
                <div class="rounded-full bg-gray-100 p-4">
                    <i class="fa-solid fa-house-chimney text-3xl"></i>
                </div>

                <h2 class="text-xl font-bold text-gray-800">
                    No Residences Available
                </h2>

                <p class="mt-2 max-w-sm text-center text-sm text-gray-500">
                    We are currently expanding to new strategic locations. Stay tuned for our upcoming residential
                    projects.
                </p>
            </div>
        @else
            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach ($residences as $residence)
                    <div class="overflow-hidden rounded-xl shadow">
                        <div class="relative overflow-hidden">
                            <span
                                class="absolute left-0 top-0 z-10 rounded-lg bg-green-500 px-4 py-1 text-sm text-white">New</span>
                            <img src="{{ asset('storage/' . $residence->image) }}"
                                class="h-48 w-full object-cover md:h-56">
                        </div>
                        <div class="p-4 text-left">
                            <h3 class="font-semibold">{{ $residence->name }}</h3>
                            <div class="flex justify-between">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                        stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 21s-7-4.35-7-11a7 7 0 1114 0c0 6.65-7 11-7 11z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    <span>{{ Str::title(strtolower($residence->city)) }}</span>
                                </div>
                                <a href="{{ route('property-list', ['location' => $residence->city]) }}"
                                    class="mt-2 rounded-full border border-blue-600 px-4 py-1 text-sm text-blue-600 hover:bg-blue-600 hover:text-white">
                                    View all
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-8">
            <a href="{{ route('residence-list') }}"
                class="mt-2 inline-flex items-center gap-2 rounded-full border border-blue-600 px-6 py-1.5 text-sm text-blue-600 transition hover:bg-blue-600 hover:text-white">
                <span>View all</span>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
            </a>
        </div>
    </section>

    {{-- WHY CHOOSE US --}}
    <section class="scroll-animate mt-12 flex bg-gray-50 py-8 md:py-16">
        <div class="mx-auto grid max-w-7xl gap-10 px-6 md:grid-cols-2">
            <div class="order-2 grid h-[280px] grid-cols-5 grid-rows-2 gap-4 md:order-1 md:h-[340px]">
                <!-- Gambar kiri atas (besar) -->
                <img src="{{ asset('images/Rectangle-1.jpg') }}"
                    class="col-span-3 row-span-1 h-full w-full rounded-xl object-cover" />

                <!-- Gambar kanan atas -->
                <img src="{{ asset('images/Rectangle-2.jpg') }}"
                    class="col-span-2 row-span-1 h-full w-full rounded-xl object-cover" />

                <!-- Gambar kiri bawah (kecil & tinggi) -->
                <img src="{{ asset('images/Rectangle-3.jpg') }}"
                    class="col-span-2 row-span-1 h-full w-full rounded-xl object-cover" />

                <!-- Gambar kanan bawah (lebar) -->
                <img src="{{ asset('images/Rectangle-4.jpg') }}"
                    class="col-span-3 row-span-1 h-full w-full rounded-xl object-cover" />
            </div>


            <div class="order-1 flex flex-col justify-center md:order-2">
                <h2 class="mb-4 text-center text-2xl font-bold md:text-left">Why Choose Us?</h2>
                <p class="mb-6 text-justify text-gray-600">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero hic soluta cumque eius suscipit,
                    commodi doloribus dicta eligendi esse eveniet laborum fugiat quam excepturi ex molestiae et nisi
                    animi nulla amet impedit sed quaerat incidunt blanditiis laudantium? Quia ipsa, consequatur quaerat
                    veritatis placeat id natus rerum cum eos suscipit! Sed?
                </p>

                <ul class="grid grid-cols-2 gap-x-8 gap-y-4 text-sm">
                    <li class="flex items-center gap-3">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-500">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        100% Secure
                    </li>

                    <li class="flex items-center gap-3">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-500">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        Customized Solutions
                    </li>

                    <li class="flex items-center gap-3">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-500">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        Trusted Developer
                    </li>

                    <li class="flex items-center gap-3">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-500">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        Understand Your Cost
                    </li>

                    <li class="flex items-center gap-3">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-500">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        Wide Property Range
                    </li>

                    <li class="flex items-center gap-3">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-500">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        Proven Expertise
                    </li>

                    <li class="flex items-center gap-3">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-500">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        Jabodetabek Area
                    </li>

                    <li class="flex items-center gap-3">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-500">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        Transparent Partnership
                    </li>
                </ul>

            </div>
        </div>
    </section>

    {{-- PROPERTY LISTING --}}
    <section class="scroll-animate mx-auto mt-12 max-w-7xl px-6 text-center">
        <h2 class="mb-4 text-2xl font-bold">
            Explore and Browse Our
            <br>
            <span class="font-secondary italic text-blue-600">Property Listing</span>
        </h2>

        @if (count($properties) == 0)
            <div class="flex flex-col items-center justify-center py-10">
                <div class="rounded-full bg-gray-100 p-4">
                    <i class="fa-solid fa-house-chimney text-3xl"></i>
                </div>

                <h2 class="text-xl font-bold text-gray-800">
                    No Properties Found
                </h2>

                <p class="mt-2 max-w-sm text-center text-sm text-gray-500">
                    We are currently adding new exclusive listings. Stay tuned to find your dream home.
                </p>
            </div>
        @else
            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach ($properties as $property)
                    <div class="overflow-hidden rounded-xl shadow">
                        <div class="relative overflow-hidden">
                            @if ($loop->index < 3)
                                <span
                                    class="absolute left-0 top-0 z-10 rounded-lg bg-green-500 px-4 py-1 text-sm text-white">
                                    New
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
                                <p class="font-bold">Rp. {{ number_format($property->price) }}</p>
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

        <div class="mt-8">
            <a href="{{ route('property-list') }}"
                class="mt-2 inline-flex items-center gap-2 rounded-full border border-blue-600 px-6 py-1.5 text-sm text-blue-600 transition hover:bg-blue-600 hover:text-white">
                <span>View all</span>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
            </a>
        </div>
    </section>

    {{-- ARTICLES LISTING --}}
    <section class="scroll-animate mt-12 bg-gray-50 py-10">
        <div class="mx-auto max-w-7xl px-6 text-center">
            <h2 class="mb-4 text-2xl font-bold">
                Recent
                <span class="font-secondary italic text-blue-600">Articles</span>
            </h2>

            @if (count($articles) == 0)
                <div class="flex flex-col items-center justify-center py-10">
                    <div class="rounded-full bg-gray-100 p-4">
                        <i class="fa-solid fa-newspaper text-3xl"></i>
                    </div>

                    <h2 class="text-xl font-bold text-gray-800">
                        No Articles Yet
                    </h2>

                    <p class="mt-2 max-w-sm text-center text-sm text-gray-500">
                        We haven't published any news yet. Check back soon for more updates.
                    </p>
                </div>
            @else
                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    @foreach ($articles as $article)
                        <div class="overflow-hidden rounded-xl shadow">
                            <img src="{{ asset('storage/' . $article->image) }}"
                                class="h-48 w-full object-cover md:h-56">
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

            <div class="mt-8">
                <a href="{{ route('article-list') }}"
                    class="mt-2 inline-flex items-center gap-2 rounded-full border border-blue-600 px-6 py-1.5 text-sm text-blue-600 transition hover:bg-blue-600 hover:text-white">
                    <span>View all</span>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- TESTIMONIAL --}}
    <section class="scroll-animate mx-auto mt-12 max-w-7xl px-6 text-center">
        <h2 class="mb-2 text-2xl font-bold">
            What Our <span class="font-secondary italic text-blue-600">Clients Say</span>
        </h2>

        @if (count($testimonials) == 0)
            <div class="flex flex-col items-center justify-center py-10">
                <div class="rounded-full bg-gray-100 p-4">
                    <i class="fa-solid fa-comments text-3xl"></i>
                </div>

                <h2 class="text-xl font-bold text-gray-800">
                    No Testimonials Yet
                </h2>

                <p class="mt-2 max-w-sm text-center text-sm text-gray-500">
                    We haven't added any client stories yet. Please check back later or be the first to share your
                    experience!
                </p>
            </div>
        @else
            <div class="mt-10 grid gap-6 md:grid-cols-3">
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

        <div class="mt-8">
            <a href="{{ route('testimonials') }}"
                class="mt-2 inline-flex items-center gap-2 rounded-full border border-blue-600 px-6 py-1.5 text-sm text-blue-600 transition hover:bg-blue-600 hover:text-white">
                <span>View all</span>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
            </a>
        </div>
    </section>
</div>
