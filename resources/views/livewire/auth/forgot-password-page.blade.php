<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-center">
        <main class="w-full max-w-md mx-auto p-6">
            <div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="p-4 sm:p-7">
                    <div class="text-center">
                        <h1 class="block text-2xl font-bold text-gray-800">Forgot password?</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Remember your password?
                            <a wire:navigate class="text-orange-500 decoration-2 hover:underline font-medium"
                                href="{{ route('login') }}">
                                Login here
                            </a>
                        </p>
                    </div>

                    <div class="mt-5">
                        <!-- Form -->
                        <form wire:submit.prevent="save">

                            @if (session('success'))
                                <div class="mt-2 bg-green-500 text-sm text-white rounded-lg p-4 mb-4" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="grid gap-y-4">
                                <!-- Form Group -->
                                <div>
                                    <label for="email" class="block text-sm mb-2">Email
                                        address</label>
                                    <div class="relative">
                                        <input type="email" id="email" wire:model="email"
                                            class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('email') border-red-500 @enderror"
                                            aria-describedby="email-error">
                                        @error('email')
                                            <div
                                                class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                                <svg class="flex-shrink-0 size-4 text-red-500"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <line x1="12" x2="12" y1="8" y2="12">
                                                    </line>
                                                    <line x1="12" x2="12.01" y1="16" y2="16">
                                                    </line>
                                                </svg>
                                            </div>
                                        @enderror
                                    </div>
                                    @error('email')
                                        <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- End Form Group -->
                                <button type="submit"
                                    class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none">Reset
                                    password</button>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
