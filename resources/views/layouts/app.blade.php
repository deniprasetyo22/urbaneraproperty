<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        <link rel="icon" href="{{ asset('images/icon.png') }}">
        <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-07KEQDJEQZ"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-07KEQDJEQZ');
            // gtag('config', 'G-07KEQDJEQZ', {
            //     'debug_mode': {{ app()->environment('local') ? 'true' : 'false' }}
            // });
        </script>

        <meta name="google-site-verification" content="UEhpcve-xQ9RZANiHmwzif6z62EtDwUt92SH2le3V3s" />
    </head>

    <body class="font-primary">

        <livewire:navbar />

        {{ $slot }}

        <livewire:footer />

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const observerOptions = {
                    root: null,
                    rootMargin: '0px',
                    threshold: 0.1 // Animasi mulai saat 10% elemen terlihat
                };

                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Hapus class hidden state
                            entry.target.classList.remove('opacity-0', 'translate-y-10');
                            // Tambah class visible state
                            entry.target.classList.add('opacity-100', 'translate-y-0');
                            // Stop observe agar animasi hanya terjadi sekali (tidak berulang saat scroll naik)
                            observer.unobserve(entry.target);
                        }
                    });
                }, observerOptions);

                // Pilih semua elemen yang punya class 'scroll-animate'
                const elements = document.querySelectorAll('.scroll-animate');
                elements.forEach(el => {
                    // Tambahkan base transition classes via JS agar kalau JS mati, konten tetap muncul
                    el.classList.add('transition-all', 'duration-1000', 'ease-out', 'opacity-0',
                        'translate-y-10');
                    observer.observe(el);
                });
            });
        </script>

        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    </body>

</html>
