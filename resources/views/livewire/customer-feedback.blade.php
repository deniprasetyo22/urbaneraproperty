<div class="bg-white">
    {{-- HERO SECTION --}}
    <livewire:hero hero_quote="Help us improve our services by sharing your feedback" hero_title="Customer Feedback"
        hero_subTitle="Lorem ipsum, dolor sit amet consectetur adipisicing elit. Assumenda quibusdam voluptas ipsum, rem nihil dolorem necessitatibus placeat saepe. Sed, numquam! Atque doloremque asperiores dignissimos? Et." />

    <div class="mx-auto max-w-7xl px-6 pt-8">
        <h2 class="mb-4 text-xl font-semibold text-gray-900">
            Customer Feedback
        </h2>

        @if ($showToast)
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
                        Feedback has been sent.
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

        <form class="space-y-4 rounded-md bg-white p-6 shadow">
            <!-- Name -->
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-900">
                    Name <span class="text-xs text-red-500">*</span>
                </label>
                <input wire:model.defer="name" type="text" placeholder="John Doe"
                    class="block w-full rounded-md border border-gray-300 bg-gray-50 p-2.5 text-sm">
                @error('name')
                    <span class="text-sm text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-900">
                    Email <span class="text-xs text-red-500">*</span>
                </label>
                <input wire:model.defer="email" type="email" placeholder="email@example.com"
                    class="block w-full rounded-md border border-gray-300 bg-gray-50 p-2.5 text-sm">
                @error('email')
                    <span class="text-sm text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-900">
                    Phone <span class="text-xs text-red-500">*</span>
                </label>
                <input wire:model.defer="phone" type="text" inputmode="numeric" pattern="[0-9]*"
                    placeholder="081234567890" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    class="block w-full rounded-md border border-gray-300 bg-gray-50 p-2.5 text-sm">
                @error('phone')
                    <span class="text-sm text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-900">
                    Category <span class="text-xs text-red-500">*</span>
                </label>
                <select wire:model.defer="category"
                    class="block w-full rounded-md border border-gray-300 bg-gray-50 p-2.5 text-sm">
                    <option value="">Select Category</option>
                    <option value="Service">Service</option>
                    <option value="Product">Product</option>
                    <option value="Support">Support</option>
                    <option value="Other">Other</option>
                </select>
                @error('category')
                    <span class="text-sm text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Message -->
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-900">
                    Message <span class="text-xs text-red-500">*</span>
                </label>
                <textarea wire:model.defer="message" rows="5" placeholder="Your message"
                    class="block w-full resize-none rounded-md border border-gray-300 bg-gray-50 p-2.5 text-sm"></textarea>
                @error('message')
                    <span class="text-sm text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            @error('recaptcha_error')
                <div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-600">
                    {{ $message }}
                </div>
            @enderror

            <button type="button" onclick="submitFeedback()" wire:loading.attr="disabled" wire:target="submit"
                class="mt-4 flex w-full items-center justify-center rounded-md bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60">

                <span wire:loading.remove wire:target="submit">Send Feedback</span>

                <span wire:loading wire:target="submit" class="flex items-center gap-2">
                    Sending...
                </span>
            </button>
        </form>

    </div>

    <script>
        function submitFeedback() {
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
