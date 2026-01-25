<div class="bg-white">
    {{-- HERO SECTION --}}
    <livewire:hero hero_quote="Discover Who We Us" hero_title="About Us"
        hero_subTitle="Lorem ipsum, dolor sit amet consectetur adipisicing elit. Assumenda quibusdam voluptas ipsum, rem nihil dolorem necessitatibus placeat saepe. Sed, numquam! Atque doloremque asperiores dignissimos? Et." />

    <div class="mx-auto max-w-7xl px-6 pt-8">

        {{-- VIDEO --}}
        <video class="rounded-base mb-10 w-full" controls>
            <source src="{{ asset($about->video) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        {{-- ABOUT --}}
        <div class="mb-10">
            <h2 class="mb-3 text-2xl font-bold">About Urbanera</h2>

            @if ($about)
                <div class="prose max-w-none text-justify text-gray-700">
                    {!! $about->about !!}
                </div>
            @endif
        </div>

        {{-- VISION --}}
        <div class="mb-10">
            <h2 class="mb-3 text-2xl font-bold">Vision</h2>

            @if ($about)
                <p class="border-l-4 border-gray-300 pl-4 text-justify italic text-gray-700">
                    {!! $about->vision !!}
                </p>
            @endif
        </div>

        {{-- MISSION --}}
        <div class="mb-10">
            <h2 class="mb-3 text-2xl font-bold">Mission</h2>

            @if ($about)
                <div
                    class="prose max-w-none text-justify text-gray-700 [&_li]:my-1 [&_li]:ml-0 [&_ol]:my-3 [&_ol]:list-inside [&_ol]:list-decimal [&_ol]:pl-0 [&_p]:mb-3 [&_ul]:my-3 [&_ul]:list-inside [&_ul]:list-disc [&_ul]:pl-0">
                    {!! $about->mission !!}
                </div>
            @endif
        </div>

        {{-- ACHIEVEMENTS --}}
        @if ($about && is_array($about->achievements))
            <div class="mb-10">
                <h2 class="mb-6 text-2xl font-bold">Achievements</h2>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    @foreach ($about->achievements as $item)
                        <div class="overflow-hidden rounded-md bg-white shadow transition hover:shadow-md">

                            {{-- Image --}}
                            @if (!empty($item['image']))
                                <div class="relative aspect-[16/9] w-full overflow-hidden rounded-t-md">
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="Achievement Image"
                                        class="absolute inset-0 h-full w-full object-cover transition-transform duration-300 hover:scale-105">
                                </div>
                            @endif

                            {{-- Content --}}
                            <div class="p-5">
                                <div class="prose max-w-none text-center text-gray-700">
                                    {!! $item['description'] ?? '' !!}
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- PORTFOLIO & HISTORY --}}
        @if ($about && is_array($about->portfolio))
            <div class="relative mb-10">

                <h2 class="mb-6 text-2xl font-bold">Portfolio & History</h2>

                <div class="space-y-12">
                    @foreach ($about->portfolio as $index => $item)
                        <div class="relative grid items-center gap-4 md:grid-cols-2">

                            {{-- DOT --}}
                            <div
                                class="absolute left-1/2 top-1/2 z-10 hidden h-6 w-6 -translate-x-1/2 -translate-y-1/2 rounded-full border-4 border-white bg-green-600 md:block">
                            </div>

                            {{-- GARIS KE BAWAH (kecuali item terakhir) --}}
                            @if (!$loop->last)
                                <div
                                    class="absolute left-1/2 top-1/2 hidden h-[120%] w-[4px] -translate-x-1/2 bg-gray-200 md:block">
                                </div>
                            @endif

                            {{-- LEFT --}}
                            <div class="{{ $index % 2 == 0 ? 'md:order-1 md:pr-12' : 'md:order-2 md:pl-12' }}">
                                @if (!empty($item['image']))
                                    <div class="aspect-[16/9] overflow-hidden rounded-md shadow">
                                        <img src="{{ asset('storage/' . $item['image']) }}"
                                            class="h-full w-full object-cover transition duration-300 hover:scale-105"
                                            alt="Portfolio image">
                                    </div>
                                @endif
                            </div>

                            {{-- RIGHT --}}
                            <div class="{{ $index % 2 == 0 ? 'md:order-2 md:pl-12' : 'md:order-1 md:pr-12' }}">
                                <div class="prose max-w-none text-justify">
                                    {{-- TITLE --}}
                                    <h3 class="mb-2 text-lg font-semibold text-gray-900">
                                        {{ $item['title'] }}
                                    </h3>

                                    {{-- DESCRIPTION --}}
                                    <div class="prose max-w-none text-justify text-gray-700">
                                        {!! $item['description'] ?? '' !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        @endif



    </div>
</div>
