@php
    $featureIcons = [
        'Air Condition' => '❄️',
        'Carport' => '🚗',
        'Swimming Pool' => '🏊',
        'Balcony' => '🏢',
        'Rooftop' => '🏠',
        'Security 24/7' => '🛡️',
        'Gym' => '🏋️',
        'Garden' => '🌿',
        'Wifi' => '📶',
        'Cctv' => '📹'
    ];
@endphp

<div class="mt-16 bg-white">
    <div class="mx-auto max-w-7xl px-6 pt-8">

        {{-- Success Toast --}}
        @if ($toastSuccess)
            <div class="fixed right-5 top-5 z-50">
                <div id="toast-success"
                    class="border-default bg-neutral-primary-soft shadow-xs flex w-full max-w-sm items-center rounded-lg border px-4 py-2.5"
                    role="alert">

                    <div
                        class="bg-success-soft text-fg-success inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 11.917 9.724 16.5 19 7.5" />
                        </svg>
                    </div>

                    <div class="ms-3 text-sm font-normal">
                        Email has been sent.
                    </div>

                    <button wire:click="closeToast"
                        class="text-body hover:bg-neutral-secondary-medium ms-auto flex h-8 w-8 items-center justify-center rounded bg-transparent">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <p class="text-md mb-3 font-semibold text-gray-500">
            <a href="{{ route('property-list') }}"class="hover:text-brand">
                Properties
            </a>/<span class="text-gray-900">Property Detail</span>
        </p>

        <!-- MAIN IMAGE -->
        {{-- PHP LOGIC: Normalisasi Data & Helper --}}
        @php
            $rawMedia = $property->media;
            $gallery = [];

            // Pastikan jadi array
            if (is_array($rawMedia)) {
                $gallery = $rawMedia;
            } elseif (is_string($rawMedia)) {
                $decoded = json_decode($rawMedia, true);
                $gallery = is_array($decoded) ? $decoded : [$rawMedia];
            }

            // Hapus item kosong
            $gallery = array_filter($gallery);
            $firstItem = $gallery[0] ?? null;

            // Tentukan item grid
            $gridItems = $showAll ? $gallery : array_slice($gallery, 0, 4);

            // Helper Cek Video
            $isVideo = fn($file) => in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), [
                'mp4',
                'mov',
                'avi',
                'webm'
            ]);
        @endphp

        @if ($firstItem)
            <div class="relative w-full">
                @if ($isVideo($firstItem))
                    {{-- TAMPILAN VIDEO UTAMA --}}
                    <video wire:click="openModal('{{ $firstItem }}')" autoplay muted loop playsinline
                        class="hover:scale-102 w-full cursor-pointer rounded-md object-cover transition">
                        <source src="{{ asset('storage/' . $firstItem) }}">
                    </video>
                @else
                    {{-- TAMPILAN GAMBAR UTAMA --}}
                    <img src="{{ asset('storage/' . $firstItem) }}" wire:click="openModal('{{ $firstItem }}')"
                        class="hover:scale-102 w-full cursor-pointer rounded-md object-cover transition">
                @endif
            </div>
        @endif

        <div class="mt-4">
            <div class="grid grid-cols-4 gap-4">
                @foreach ($gridItems as $item)
                    {{-- WRAPPER UTAMA (Wajib relative agar icon bisa nempel) --}}
                    {{-- Saya pindahkan wire:click ke sini agar area klik lebih luas --}}
                    <div class="group relative cursor-pointer overflow-hidden rounded-md"
                        wire:click="openModal('{{ $item }}')">

                        @if ($isVideo($item))
                            {{-- ITEM GRID VIDEO --}}
                            {{-- Hapus rounded-md di sini karena sudah ada di wrapper --}}
                            <video muted loop onmouseover="this.play()" onmouseout="this.pause()"
                                class="h-12 w-full object-cover transition duration-500 group-hover:scale-110 md:h-48">
                                <source src="{{ asset('storage/' . $item) }}">
                            </video>

                            {{-- 1. ICON PLAY TENGAH (Hilang saat di-hover/play) --}}
                            <div
                                class="pointer-events-none absolute inset-0 z-10 flex items-center justify-center transition duration-300 group-hover:opacity-0">
                                <div class="rounded-full bg-black/30 p-2 backdrop-blur-[2px]">
                                    <i class="fa-solid fa-play text-xs text-white opacity-90 md:text-lg"></i>
                                </div>
                            </div>

                            {{-- 2. ICON VIDEO POJOK (Tetap ada sebagai penanda) --}}
                            <div class="pointer-events-none absolute right-1 top-1 z-10">
                                <i
                                    class="fa-solid fa-video text-[10px] text-white shadow-black drop-shadow-md md:text-xs"></i>
                            </div>
                        @else
                            {{-- ITEM GRID GAMBAR --}}
                            <img src="{{ asset('storage/' . $item) }}"
                                class="h-12 w-full object-cover transition duration-500 group-hover:scale-110 md:h-48">
                        @endif

                    </div>
                @endforeach
            </div>

            {{-- BUTTON --}}
            @if (count($gallery) > 4)
                <div class="mt-4 flex justify-center">
                    <button type="button" wire:click="toggleShow" wire:loading.attr="disabled" wire:target="toggleShow"
                        class="border-brand bg-neutral-primary text-fg-brand hover:bg-brand relative rounded-full border px-5 py-2 text-xs leading-5 transition hover:text-white disabled:cursor-not-allowed disabled:opacity-60">

                        <span wire:loading.remove wire:target="toggleShow">
                            Show {{ $showAll ? 'Less' : 'More' }}
                        </span>

                        <span wire:loading wire:target="toggleShow">
                            Loading...
                        </span>

                    </button>
                </div>
            @endif
        </div>


        <div class="mt-10 grid grid-cols-1 gap-10 lg:grid-cols-3">

            <!-- LEFT CONTENT -->
            <div class="lg:col-span-2">

                <h1 class="text-3xl font-bold text-gray-900">
                    {{ $property->name }}
                </h1>

                <p class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 21s-7-4.35-7-11a7 7 0 1114 0c0 6.65-7 11-7 11z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    <span>{{ Str::title(strtolower($property->residence->city)) }}</span>
                </p>

                <div
                    class="prose mt-4 max-w-none text-justify text-gray-700 [&_li]:my-1 [&_li]:ml-0 [&_ol]:my-3 [&_ol]:list-inside [&_ol]:list-decimal [&_ol]:pl-0 [&_p]:mb-3 [&_ul]:my-3 [&_ul]:list-inside [&_ul]:list-disc [&_ul]:pl-0">
                    {!! $property->description !!}
                </div>

                <!-- LOCATION INFO -->
                <div class="mt-6">
                    <h3 class="mb-2 text-lg font-semibold">Nearby Locations and Amenities :</h3>
                    <div
                        class="prose max-w-none text-justify text-gray-700 [&_li]:my-1 [&_li]:ml-0 [&_ol]:my-3 [&_ol]:list-inside [&_ol]:list-decimal [&_ol]:pl-0 [&_p]:mb-3 [&_ul]:my-3 [&_ul]:list-inside [&_ul]:list-disc [&_ul]:pl-0">
                        {!! $property->nearby_amenities !!}
                    </div>
                </div>

                <!-- DETAILS -->
                <div class="mt-10">
                    <h3 class="mb-4 text-lg font-semibold">Property Details</h3>
                    <div>
                        <div class="grid grid-cols-2 bg-gray-50 p-4 text-sm">
                            <div class="text-gray-600">
                                <span>Type</span>
                            </div>

                            <div class="font-medium text-gray-900">
                                {{ $property->type }}
                            </div>
                        </div>
                        @foreach ($property->property_details as $index => $item)
                            <div
                                class="{{ $index % 2 == 1 ? 'bg-gray-50' : 'bg-white' }} grid grid-cols-2 p-4 text-sm">

                                <div class="text-gray-600">
                                    {{ $item['label'] }}
                                </div>

                                <div class="font-medium text-gray-900">
                                    {{ $item['value'] }}
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDEBAR -->
            <div class="space-y-6">

                <div class="border-default-medium rounded-md border p-5 shadow">
                    <p class="text-sm text-gray-500">Start from</p>
                    @if ($property->status == 'Available')
                        <p class="mt-1 text-xl font-bold text-gray-900">
                            IDR {{ number_format($property->price) }}
                        </p>
                    @elseif ($property->status == 'Sold Out')
                        <p class="mt-1 text-xl font-bold text-red-500">
                            Sold Out
                        </p>
                    @endif
                </div>

                <!-- KPR -->
                <div class="border-default-medium space-y-4 rounded-md border p-5 shadow">
                    <h3 class="font-semibold">KPR Simulator</h3>

                    {{-- PRICE --}}
                    <div>
                        <label class="text-heading mb-2 block text-sm font-medium">Price <span
                                class="text-xs text-red-500">*</span></label>
                        <div class="relative">
                            <span
                                class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-500">
                                Rp.
                            </span>

                            <input type="text" x-data
                                x-on:input="
                                let value = $event.target.value.replace(/[^0-9]/g, '');
                                $event.target.value = new Intl.NumberFormat('id-ID').format(value);
                                $wire.set('price', value);"
                                value="{{ $property->status == 'Available' ? number_format($price ?? $property->price, 0, ',', '.') : number_format(0, 0, ',', '.') }}"
                                class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs block w-full cursor-not-allowed border py-2.5 pl-10 pr-3 text-sm"
                                placeholder="0" required>
                        </div>
                        @error('price')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- BANK --}}
                    <div>
                        <label class="text-heading mb-2 block text-sm font-medium">Bank <span
                                class="text-xs text-red-500">*</span></label>
                        <select wire:model.live="bank_id" required
                            class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs block w-full border px-3 py-2.5 text-sm">
                            <option value="">Choose a bank</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                        @error('bank_id')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- INTEREST --}}
                    <div>
                        <label class="text-heading mb-2 block text-sm font-medium">Interest Rate (%) <span
                                class="text-xs text-red-500">*</span></label>
                        <input disabled required type="number" step="0.01" wire:model.live="interest_rate"
                            placeholder="0.00"
                            class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs block w-full cursor-not-allowed border px-3 py-2.5 text-sm">
                        @error('interest_rate')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- DOWN PAYMENT --}}
                    <div>
                        <label class="text-heading mb-2 block text-sm font-medium">Down Payment <span
                                class="text-xs text-red-500">*</span></label>
                        <div class="relative">
                            <span
                                class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-500">
                                Rp.
                            </span>

                            <input type="text" x-data
                                x-on:input="
                                let value = $event.target.value.replace(/[^0-9]/g, '');
                                $event.target.value = new Intl.NumberFormat('id-ID').format(value);
                                $wire.set('down_payment', value);
                            "
                                value="{{ number_format($down_payment ?? 0, 0, ',', '.') }}"
                                class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs block w-full border py-2.5 pl-10 pr-3 text-sm"
                                placeholder="0" required>
                        </div>
                        @error('down_payment')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- TENOR --}}
                    <div>
                        <label class="text-heading mb-2 block text-sm font-medium">Tenor (Years) <span
                                class="text-xs text-red-500">*</span></label>
                        <select wire:model.live="tenor" required
                            class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs block w-full border px-3 py-2.5 text-sm">
                            <option value="">Choose tenor</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                        </select>
                        @error('tenor')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- BUTTON --}}
                    <button wire:click="calculateKpr" wire:loading.attr="disabled" wire:target="calculateKpr"
                        class="bg-brand w-full rounded-full py-2 text-sm font-semibold text-white hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-60">

                        <span wire:loading.remove wire:target="calculateKpr">
                            Calculate Now
                        </span>

                        <span wire:loading wire:target="calculateKpr" class="flex items-center justify-center gap-2">
                            Calculating...
                        </span>
                    </button>


                    {{-- RESULT --}}
                    @if ($monthly_installment > 0)
                        <div class="bg-neutral-secondary-medium rounded-lg p-4 text-center">
                            <p class="text-sm text-gray-500">Estimated Monthly Installment</p>
                            <p class="text-heading text-lg font-bold">
                                Rp {{ number_format($monthly_installment, 0, ',', '.') }} / month
                            </p>
                        </div>
                    @endif
                </div>

                <a href="https://wa.me/6281388860580" rel="noopener noreferrer"
                    class="bg-brand hover:bg-brand/90 flex w-full items-center justify-center gap-2 rounded-full py-3 text-center font-medium text-white transition">

                    <i class="fa-brands fa-whatsapp text-lg"></i>
                    <span>Ask via WhatsApp</span>

                </a>


                <button wire:click="toggleModalBrochure"
                    class="bg-brand hover:bg-brand/90 flex w-full items-center justify-center gap-2 rounded-full py-3 text-center font-medium text-white transition">
                    <i class="fa-solid fa-download"></i> Request E-Brochure
                </button>

            </div>
        </div>

        {{-- MODAL BROCHURE --}}
        <div
            class="{{ $modalBrochure ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50">
            <div class="relative w-full max-w-md p-4">
                <div class="bg-neutral-primary-soft border-default rounded-base relative border p-4 shadow-sm md:p-6">

                    {{-- HEADER --}}
                    <div class="border-default flex items-center justify-between border-b pb-4 md:pb-5">
                        <h3 class="text-heading text-lg font-medium">
                            Request E-Brochure
                        </h3>

                        {{-- ❌ tombol close kamu tidak terhubung Livewire --}}
                        <button wire:click="toggleModalBrochure"
                            class="text-body hover:bg-neutral-tertiary hover:text-heading rounded-base inline-flex h-9 w-9 items-center justify-center">
                            ✕
                        </button>
                    </div>

                    {{-- BODY --}}
                    <div class="py-6">
                        <form>
                            <div class="mb-5">
                                <label for="name" class="text-heading mb-2.5 block text-sm font-medium">
                                    Name <span class="text-xs text-red-500">*</span>
                                </label>
                                <input type="name" id="name" wire:model.live="name"
                                    class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border px-3 py-2.5 text-sm"
                                    placeholder="John Doe" />
                                @error('name')
                                    <div><span class="text-xs text-red-500">{{ $message }}</span></div>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="email" class="text-heading mb-2.5 block text-sm font-medium">
                                    Email <span class="text-xs text-red-500">*</span>
                                </label>
                                <input type="email" id="email" wire:model.live="email"
                                    class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border px-3 py-2.5 text-sm"
                                    placeholder="email@example.com" />
                                @error('email')
                                    <div><span class="text-xs text-red-500">{{ $message }}</span></div>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="phone" class="text-heading mb-2.5 block text-sm font-medium">
                                    Phone <span class="text-xs text-red-500">*</span>
                                </label>
                                <input id="phone" type="text" inputmode="numeric" pattern="[0-9]*"
                                    wire:model.defer="phone" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border px-3 py-2.5 text-sm"
                                    placeholder="08123456789" />
                                @error('phone')
                                    <div><span class="text-xs text-red-500">{{ $message }}</span></div>
                                @enderror
                            </div>

                            @error('recaptcha_error')
                                <div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-600">
                                    {{ $message }}
                                </div>
                            @enderror

                            <button type="button" onclick="sendRequestBrochure()" wire:loading.attr="disabled"
                                wire:target="sendRequestBrochure"
                                class="bg-brand hover:bg-brand-strong focus:ring-brand-medium shadow-xs rounded-base box-border w-full border border-transparent px-4 py-2.5 text-sm font-medium leading-5 text-white focus:outline-none focus:ring-4 disabled:cursor-not-allowed disabled:opacity-60">

                                <span wire:loading.remove wire:target="sendRequestBrochure">
                                    <i class="fa-solid fa-paper-plane mr-2"></i> Send
                                </span>

                                <span wire:loading wire:target="sendRequestBrochure"
                                    class="flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-paper-plane mr-2"></i> Sending...
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- FEATURES -->
        <div class="mt-8 md:mt-16">
            <h3 class="mb-4 text-lg font-semibold">Features</h3>

            <div class="flex flex-wrap gap-2">
                @foreach ($property->property_features as $feature)
                    <div
                        class="flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-sm text-blue-700">

                        <span>
                            {{ $featureIcons[$feature] ?? '•' }}
                        </span>

                        <span class="font-medium">
                            {{ $feature }}
                        </span>

                    </div>
                @endforeach
            </div>
        </div>


        <!-- FLOOR PLAN -->
        <div class="mt-10">
            <h3 class="mb-4 text-lg font-semibold">Floor Plan</h3>

            <div id="indicators-carousel" class="relative w-full" data-carousel="static" wire:ignore>

                <div id="floorplan-carousel"
                    class="rounded-base relative h-[200px] overflow-hidden bg-white sm:h-[260px] md:h-[420px] lg:h-[600px] xl:h-[720px]"
                    data-carousel="static">

                    @foreach ($property->floor_plan as $index => $item)
                        <div class="hidden duration-700 ease-in-out"
                            data-carousel-item="{{ $index === 0 ? 'active' : '' }}">

                            <img src="{{ asset('storage/' . $item) }}"
                                wire:click="openModalFloorPlan('{{ $item }}')"
                                class="absolute left-1/2 top-1/2 h-full w-full -translate-x-1/2 -translate-y-1/2 cursor-pointer object-cover"
                                alt="Floor plan {{ $index + 1 }}">
                        </div>
                    @endforeach
                </div>


                <!-- Indicators -->
                <div class="absolute bottom-5 left-1/2 z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse">
                    @foreach ($property->floor_plan as $i => $item)
                        <button type="button"
                            class="rounded-base h-3 w-3 border border-gray-500 bg-white aria-[current=true]:bg-blue-500"
                            aria-label="Slide {{ $i + 1 }}" data-carousel-slide-to="{{ $i }}">
                        </button>
                    @endforeach
                </div>

                <!-- Prev -->
                <button type="button"
                    class="group absolute start-0 top-0 z-30 flex h-full cursor-pointer items-center justify-center focus:outline-none"
                    data-carousel-prev>
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 group-hover:bg-gray-200 group-focus:ring-4 group-focus:ring-white md:h-12 md:w-12">
                        <svg class="h-5 w-5 text-gray-800 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m15 19-7-7 7-7" />
                        </svg>
                    </span>
                </button>

                <!-- Next -->
                <button type="button"
                    class="group absolute end-0 top-0 z-30 flex h-full cursor-pointer items-center justify-center focus:outline-none"
                    data-carousel-next>
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 group-hover:bg-gray-200 group-focus:ring-4 group-focus:ring-white md:h-12 md:w-12">
                        <svg class="h-5 w-5 text-gray-800 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m9 5 7 7-7 7" />
                        </svg>
                    </span>
                </button>
            </div>

        </div>

        {{-- MAPS --}}
        <div class="my-10 w-full">
            <h3 class="mb-2 text-lg font-semibold">Maps</h3>
            <p class="mb-4 text-sm text-gray-500">{{ $property->property_address }}</p>

            <div
                class="h-[260px] w-full overflow-hidden rounded-md sm:h-[360px] md:h-[460px] lg:h-[560px] xl:h-[640px] [&>iframe]:h-full [&>iframe]:w-full [&>iframe]:border-0">
                {!! $property->map !!}
            </div>
        </div>

        {{-- MODAL --}}
        @if ($showModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80" x-data
                x-on:keydown.window.escape="$wire.closeModal()" x-on:keydown.window.arrow-right="$wire.nextImage()"
                x-on:keydown.window.arrow-left="$wire.prevImage()">

                <div class="absolute inset-0" wire:click="closeModal"></div>

                <div class="relative z-10 flex w-full max-w-5xl items-center px-4">

                    {{-- Tombol Prev --}}
                    <button wire:click="prevImage"
                        class="absolute left-4 z-30 rounded-full bg-black/40 p-2 text-white transition hover:bg-black/50">
                        <svg class="h-6 w-6 md:h-8 md:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <div class="relative flex w-full items-center justify-center overflow-hidden rounded-md">
                        <button wire:click="closeModal"
                            class="absolute right-0 top-0 z-40 flex h-6 w-6 items-center justify-center rounded-full bg-black/40 text-white transition hover:bg-black/50 md:h-9 md:w-9">
                            ✕
                        </button>

                        @if ($isVideo($activeImage))
                            <video controls autoplay class="max-h-[85vh] w-auto bg-black object-contain">
                                <source src="{{ asset('storage/' . $activeImage) }}">
                            </video>
                        @else
                            <img src="{{ asset('storage/' . $activeImage) }}"
                                class="max-h-[85vh] w-auto select-none object-contain shadow-2xl">
                        @endif

                        {{-- Label Index (Opsional) --}}
                        <div
                            class="absolute bottom-4 left-1/2 -translate-x-1/2 rounded-full bg-black/50 px-3 py-1 text-xs text-white">
                            {{ $currentIndex + 1 }} /
                            {{ count(array_filter(is_array($property->media) ? $property->media : json_decode($property->media, true) ?? [])) }}
                        </div>
                    </div>

                    {{-- Tombol Next --}}
                    <button wire:click="nextImage"
                        class="absolute right-4 z-30 rounded-full bg-black/40 p-2 text-white transition hover:bg-black/50">
                        <svg class="h-6 w-6 md:h-8 md:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif


        {{-- FLOOR PLAN MODAL --}}
        @if ($showModalFloorPlan)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80" x-data
                x-on:keydown.window.escape="$wire.closeModalFloorPlan()"
                x-on:keydown.window.arrow-right="$wire.nextImageFloorPlan()"
                x-on:keydown.window.arrow-left="$wire.prevImageFloorPlan()">

                <div class="absolute inset-0" wire:click="closeModalFloorPlan"></div>

                <div class="relative z-10 flex w-full max-w-5xl items-center px-4">

                    {{-- Tombol Prev --}}
                    <button wire:click.stop="prevImageFloorPlan"
                        class="absolute left-4 z-30 rounded-full bg-black/40 p-2 text-white transition hover:bg-black/50">
                        <svg class="h-6 w-6 md:h-8 md:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <div class="relative flex w-full items-center justify-center overflow-hidden rounded-md">
                        <button wire:click="closeModalFloorPlan"
                            class="absolute right-0 top-0 z-40 flex h-6 w-6 items-center justify-center rounded-full bg-black/40 text-white transition hover:bg-black/50 md:h-9 md:w-9">
                            ✕
                        </button>

                        <img src="{{ asset('storage/' . $activeImage) }}"
                            class="max-h-[85vh] w-auto select-none object-contain shadow-2xl">

                        {{-- Label Index --}}
                        {{-- PERBAIKAN: Hitung floor_plan, bukan media --}}
                        <div
                            class="absolute bottom-4 left-1/2 -translate-x-1/2 rounded-full bg-black/50 px-3 py-1 text-xs text-white">
                            {{ $currentIndexFloorPlan + 1 }} /
                            {{ count(is_array($property->floor_plan) ? $property->floor_plan : json_decode($property->floor_plan, true) ?? []) }}
                        </div>
                    </div>

                    {{-- Tombol Next --}}
                    <button wire:click.stop="nextImageFloorPlan"
                        class="absolute right-4 z-30 rounded-full bg-black/40 p-2 text-white transition hover:bg-black/50">
                        <svg class="h-6 w-6 md:h-8 md:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

    </div>

    <script>
        function sendRequestBrochure() {
            // Cek apakah grecaptcha loaded
            if (typeof grecaptcha === 'undefined') {
                alert('Recaptcha not ready. Please refresh.');
                return;
            }

            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {
                        action: 'submit'
                    })
                    .then(function(token) {
                        // Panggil method 'sendRequestBrochure' di backend dengan token
                        @this.call('sendRequestBrochure', token);
                    });
            });
        }

        // Script untuk Toast (Bawaan anda)
        document.addEventListener('livewire:init', () => {
            Livewire.on('toast-shown', () => {
                setTimeout(() => {
                    Livewire.dispatch('close-toast')
                }, 3000)
            })
        })
    </script>
</div>
