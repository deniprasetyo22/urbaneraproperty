<div>
    <section class="relative">

        {{-- HERO WRAPPER --}}
        <div class="relative h-[600px] bg-cover bg-center md:h-[720px]"
            style="background-image:url('{{ asset('images/banner.webp') }}')">

            {{-- NAVBAR (HARUS PALING ATAS) --}}
            <div class="relative z-30">
                <livewire:navbar />
            </div>

            {{-- OVERLAY (DI BAWAH NAVBAR) --}}
            <div class="pointer-events-none absolute inset-0 z-10 bg-black/40"></div>

            {{-- HERO CONTENT --}}
            <div class="relative z-20 flex h-full items-center">
                <div class="mx-auto px-6 text-center text-white">
                    <h1 class="mb-8 text-3xl font-bold md:text-6xl">
                        {{ $hero_quote }}
                    </h1>

                    <h2 class="font-secondary mb-8 text-2xl font-light text-gray-200 md:text-5xl">
                        {{ $hero_title }}
                    </h2>

                    <h3 class="mx-auto mb-8 max-w-4xl text-center text-sm font-light text-gray-200 md:text-lg">
                        {{ $hero_subTitle }}
                    </h3>

                </div>
            </div>

        </div>
    </section>
</div>
