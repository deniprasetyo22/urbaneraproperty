<footer class="bg-secondary relative z-30 mt-12 text-white">
    <div class="mx-auto px-8 py-14">
        <div class="grid gap-10 md:grid-cols-5">

            <!-- BRAND -->
            <div>
                <div class="mb-4 flex items-center gap-2 md:justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Urbanera" class="h-10">
                </div>

                <!-- SOCIAL ICONS -->
                <div class="pointer-events-auto relative z-30 mt-4 flex gap-3 md:justify-center">
                    <a href="https://wa.me/6281388860580"
                        class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-green-500 hover:bg-gray-100">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="#"
                        class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-red-500 hover:bg-gray-100">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    <a href="https://www.instagram.com/urbanera_id/"
                        class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-pink-500 hover:bg-gray-100">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://www.tiktok.com/@urbanera_id"
                        class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-black hover:bg-gray-100">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>
                </div>
            </div>

            <!-- QUICK LINKS -->
            <div>
                <h3 class="mb-4 font-semibold text-white">Quick Links</h3>
                <ul class="text-tertiary space-y-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="flex items-center gap-2 hover:text-white">
                            <i class="fa-solid fa-house text-xs"></i>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('article-list') }}" class="flex items-center gap-2 hover:text-white">
                            <i class="fa-regular fa-newspaper text-xs"></i>
                            Articles
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="flex items-center gap-2 hover:text-white">
                            <i class="fa-solid fa-circle-info text-xs"></i>
                            About
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="flex items-center gap-2 hover:text-white">
                            <i class="fa-solid fa-envelope text-xs"></i>
                            Contact
                        </a>
                    </li>
                </ul>
            </div>

            <!-- OFFERS -->
            <div>
                <h3 class="mb-4 font-semibold text-white">Offers</h3>
                <ul class="text-tertiary space-y-2 text-sm">
                    <li>
                        <a href="{{ route('property-list') }}" class="flex items-center gap-2 hover:text-white">
                            <i class="fa-solid fa-building text-xs"></i>
                            Properties
                        </a>
                    </li>
                </ul>
            </div>

            <!-- SOCIAL MEDIA -->
            <div>
                <h3 class="mb-4 font-semibold text-white">Social Media</h3>
                <ul class="text-tertiary space-y-2 text-sm">
                    <li>
                        <a href="#" class="flex items-center gap-2 hover:text-white">
                            <i class="fa-brands fa-youtube text-xs"></i>
                            YouTube
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/urbanera_id/"
                            class="flex items-center gap-2 hover:text-white">
                            <i class="fa-brands fa-instagram text-xs"></i>
                            Instagram
                        </a>
                    </li>
                    <li>
                        <a href="https://www.tiktok.com/@urbanera_id" class="flex items-center gap-2 hover:text-white">
                            <i class="fa-brands fa-tiktok text-xs"></i>
                            Tiktok
                        </a>
                    </li>
                </ul>
            </div>

            <!-- CONTACT -->
            <div>
                <h3 class="mb-4 font-semibold text-white">Contact Us</h3>
                <ul class="text-tertiary space-y-2 text-sm">
                    <li class="flex items-center gap-2">
                        <a href="https://wa.me/6281388860580">
                            <i class="fa-brands fa-whatsapp"></i>
                            0813-8886-0580 (admin)
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <a href="tel:081388860580">
                            <i class="fa-solid fa-phone"></i>
                            0813-8886-0580 (admin)
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <a href="mailto:info@urbanera.id">
                            <i class="fa-solid fa-envelope"></i>
                            info@urbanera.id
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <!-- COPYRIGHT -->
    <div class="text-tertiary pb-6 text-center text-xs">
        ©2025 Urbanera. All rights reserved
    </div>
</footer>
