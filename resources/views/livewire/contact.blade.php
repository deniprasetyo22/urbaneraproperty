<div>
    {{-- HERO SECTION --}}
    <livewire:hero hero_quote="We're Here to Help!" hero_title="Contact"
        hero_subTitle="Lorem ipsum, dolor sit amet consectetur adipisicing elit. Assumenda quibusdam voluptas ipsum, rem nihil dolorem necessitatibus placeat saepe. Sed, numquam! Atque doloremque asperiores dignissimos? Et." />

    <div class="mx-auto max-w-7xl px-6 pt-8">

        <div class="grid items-start gap-10 lg:grid-cols-2">

            {{-- LEFT --}}
            <div>
                <h2 class="mb-3 text-3xl font-bold">Let’s Get in Touch!</h2>
                <p class="mb-6 text-gray-600">
                    Lorem ipsum dolor sit amet consectetur. Ut ac tempus enim ipsum vitae bibendum neque ut
                    ultrices.
                </p>

                {{-- MAP --}}
                <div class="mb-6 overflow-hidden rounded-md shadow">
                    <iframe class="h-72 w-full border-0"
                        src="https://www.google.com/maps?q=Tapos,Depok&output=embed"></iframe>
                </div>

                {{-- INFO --}}
                <div class="rounded-md bg-white p-6 shadow">
                    <h3 class="mb-2 text-lg font-semibold">Urbanera Head Office</h3>
                    <p class="mb-4 text-sm text-gray-600">
                        Jl. Raya Tapos, Cimpaeun, Kec. Tapos, Kota Depok, Jawa Barat 16459, Indonesia
                    </p>

                    <ul class="space-y-2 text-sm text-gray-700">
                        <li>
                            <a href="tel:0821-1099-1639" class="hover:text-brand hover:underline">
                                <i class="fa-solid fa-phone"></i> 0821-1099-1639
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/6282110991639" class="hover:text-brand hover:underline">
                                <i class="fa-brands fa-whatsapp"></i> 0821-1099-1639
                            </a>
                        </li>
                        <li>
                            <a href="mailto:urbanera.id@gmail.com" class="hover:text-brand hover:underline">
                                <i class="fa-solid fa-envelope"></i> urbanera.id@gmail.com
                            </a>
                        </li>
                        <li>
                            <a href="https://instagram.com/urbanera_id" class="hover:text-brand hover:underline">
                                <i class="fa-brands fa-instagram"></i> @urbanera_id
                            </a>
                        </li>
                        <li>
                            <a href="https://tiktok.com/@urbanera_id" class="hover:text-brand hover:underline">
                                <i class="fa-brands fa-tiktok"></i> @urbanera_id
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="rounded-md bg-white p-6 shadow">

                @if ($showToast)
                    <div class="fixed right-5 top-5 z-50">
                        <div id="toast-success"
                            class="border-default bg-neutral-primary-soft shadow-xs flex w-full max-w-sm items-center rounded-lg border px-4 py-2.5"
                            role="alert">

                            <div
                                class="bg-success-soft text-fg-success inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                            </div>

                            <div class="ms-3 text-sm font-normal">
                                Message has been sent.
                            </div>

                            <button wire:click="closeToast"
                                class="text-body hover:bg-neutral-secondary-medium ms-auto flex h-8 w-8 items-center justify-center rounded bg-transparent">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                <form wire:submit.prevent="submit" class="space-y-4">

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-900">
                            Name <span class="text-xs text-red-500">*</span>
                        </label>
                        <input wire:model.defer="name" type="text" placeholder="John Doe"
                            class="block w-full rounded-md border border-gray-300 bg-gray-50 p-2.5 text-sm">
                        @error('name')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-900">
                            Email <span class="text-xs text-red-500">*</span>
                        </label>
                        <input type="email" wire:model.defer="email" placeholder="email@example.com"
                            class="block w-full rounded-md border border-gray-300 bg-gray-50 p-2.5 text-sm">
                        @error('email')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-900">
                            Phone <span class="text-xs text-red-500">*</span>
                        </label>
                        <input type="text" wire:model.defer="phone" inputmode="numeric" pattern="[0-9]*"
                            placeholder="081234567890" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="block w-full rounded-md border border-gray-300 bg-gray-50 p-2.5 text-sm">
                        @error('phone')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-900">
                            Address <span class="text-xs text-red-500">*</span>
                        </label>
                        <textarea rows="4" wire:model.defer="address" placeholder="Your Address"
                            class="block w-full rounded-md border border-gray-300 bg-gray-50 p-2.5 text-sm"></textarea>
                        @error('address')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-900">
                            Message <span class="text-xs text-red-500">*</span>
                        </label>
                        <textarea rows="4" wire:model.defer="message" placeholder="Your message"
                            class="block w-full rounded-md border border-gray-300 bg-gray-50 p-2.5 text-sm"></textarea>
                        @error('message')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    @error('recaptcha_error')
                        <div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-600">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Button -->
                    <button type="button" onclick="submitMessage()" wire:loading.attr="disabled" wire:target="submit"
                        class="flex w-full items-center justify-center rounded-md bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60">

                        <span wire:loading.remove wire:target="submit">Send Feedback</span>

                        <span wire:loading wire:target="submit" class="flex items-center gap-2">
                            Sending...
                        </span>
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        function submitMessage() {
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
                        // Panggil method 'submit' di backend dengan token
                        @this.call('submit', token);
                    });
            });
        }

        document.addEventListener('livewire:init', () => {
            Livewire.on('toast-shown', () => {
                setTimeout(() => {
                    Livewire.dispatch('close-toast')
                }, 3000)
            })
        })
    </script>
</div>
