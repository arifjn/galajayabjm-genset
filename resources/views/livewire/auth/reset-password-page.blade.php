<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-center">
        <main class="w-full max-w-md mx-auto p-6">
            <div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="p-4 sm:p-7">
                    <div class="text-center">
                        <h1 class="block text-2xl font-bold text-gray-800">Reset password</h1>
                    </div>

                    <div class="mt-5">
                        <!-- Form -->
                        <form wire:submit.prevent="save">

                            @if (session('error'))
                                <div class="mt-2 bg-red-500 text-sm text-white rounded-lg p-4 mb-4" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="grid gap-y-4">

                                <!-- Form PW -->
                                <div>
                                    <label for="hs-toggle-password" class="block text-sm mb-2">Password</label>
                                    <div class="relative">
                                        <input id="hs-toggle-password" type="password" wire:model="password"
                                            class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('password') border-red-500 @enderror">
                                        <button type="button"
                                            data-hs-toggle-password='{"target": "#hs-toggle-password"}'
                                            class="absolute top-0 end-0 p-3.5 rounded-e-md">
                                            <svg class="flex-shrink-0 size-3.5 text-gray-400" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path class="hs-password-active:hidden"
                                                    d="M9.88 9.88a3 3 0 1 0 4.24 4.24">
                                                </path>
                                                <path class="hs-password-active:hidden"
                                                    d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68">
                                                </path>
                                                <path class="hs-password-active:hidden"
                                                    d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61">
                                                </path>
                                                <line class="hs-password-active:hidden" x1="2" x2="22"
                                                    y1="2" y2="22"></line>
                                                <path class="hidden hs-password-active:block"
                                                    d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                <circle class="hidden hs-password-active:block" cx="12"
                                                    cy="12" r="3"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                    @error('password')
                                        <p class="text-xs text-red-600 mt-2" id="password-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- End Form PW -->

                                <!-- Form PW Confirm -->
                                <div>
                                    <label for="hs-toggle-password-confirmation" class="block text-sm mb-2">Konfirmasi
                                        Password</label>
                                    <div class="relative">
                                        <input id="hs-toggle-password-confirmation" type="password"
                                            wire:model="password_confirmation"
                                            class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('password') border-red-500 @enderror">
                                        <button type="button"
                                            data-hs-toggle-password='{"target": "#hs-toggle-password-confirmation"}'
                                            class="absolute top-0 end-0 p-3.5 rounded-e-md">
                                            <svg class="flex-shrink-0 size-3.5 text-gray-400" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path class="hs-password-active:hidden"
                                                    d="M9.88 9.88a3 3 0 1 0 4.24 4.24">
                                                </path>
                                                <path class="hs-password-active:hidden"
                                                    d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68">
                                                </path>
                                                <path class="hs-password-active:hidden"
                                                    d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61">
                                                </path>
                                                <line class="hs-password-active:hidden" x1="2" x2="22"
                                                    y1="2" y2="22"></line>
                                                <path class="hidden hs-password-active:block"
                                                    d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                <circle class="hidden hs-password-active:block" cx="12"
                                                    cy="12" r="3"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <!-- End Form PW Confirm -->

                                <button type="submit"
                                    class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none">
                                    Save password
                                </button>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
