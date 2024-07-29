<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-center">
        <main class="lg:w-1/2 w-full mx-auto p-6">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="p-4 sm:p-7">
                    <div class="text-center">
                        <h1 class="block text-2xl font-bold text-gray-800">Register</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Sudah punya akun?
                            <a wire:navigate class="text-orange-500 decoration-2 hover:underline font-medium"
                                href="{{ route('login') }}">
                                Login disini!
                            </a>
                        </p>
                    </div>
                    <hr class="my-5 border-slate-300">
                    <!-- Form -->
                    <form wire:submit.prevent="save">
                        <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-x-4 gap-y-4">

                            <!-- Form Nama -->
                            <div class="lg:col-span-2">
                                <label for="name" class="block text-sm mb-2">Nama Lengkap</label>
                                <div class="relative">
                                    <input type="text" id="name" wire:model="name" autofocus
                                        class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('name') border-red-500 @enderror"
                                        aria-describedby="name-error" autofocus>
                                    @error('name')
                                        <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                            <svg class="flex-shrink-0 size-4 text-red-500"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" x2="12" y1="8" y2="12"></line>
                                                <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                            </svg>
                                        </div>
                                    @enderror
                                </div>
                                @error('name')
                                    <p class="text-xs text-red-600 mt-2" id="name-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- End Form Nama -->

                            <!-- Form Tempat Lahir -->
                            <div>
                                <label for="tempat_lahir" class="block text-sm mb-2">Tempat Lahir</label>
                                <div class="relative">
                                    <input type="text" id="tempat_lahir" wire:model="tempat_lahir"
                                        class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('tempat_lahir') border-red-500 @enderror"
                                        aria-describedby="tempat_lahir-error">
                                    @error('tempat_lahir')
                                        <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                            <svg class="flex-shrink-0 size-4 text-red-500"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" x2="12" y1="8" y2="12"></line>
                                                <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                            </svg>
                                        </div>
                                    @enderror
                                </div>
                                @error('tempat_lahir')
                                    <p class="text-xs text-red-600 mt-2" id="tempat_lahir-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- End Form Tempat Lahir -->

                            <!-- Form Tgl Lahir -->
                            <div>
                                <label for="tgl_lahir" class="block text-sm mb-2">Tanggal Lahir</label>
                                <div class="relative">
                                    <input type="date" id="tgl_lahir" wire:model="tgl_lahir"
                                        class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('tgl_lahir') border-red-500 @enderror"
                                        aria-describedby="tgl_lahir-error">
                                </div>
                                @error('tgl_lahir')
                                    <p class="text-xs text-red-600 mt-2" id="tgl_lahir-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- End Form Tgl Lahir -->

                            <!-- Form HP -->
                            <div>
                                <label for="no_telp" class="block text-sm mb-2">No. HP</label>
                                <div class="relative">
                                    <input type="telp" id="no_telp" wire:model="no_telp"
                                        class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('no_telp') border-red-500 @enderror"
                                        aria-describedby="no_telp-error">
                                    @error('no_telp')
                                        <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                            <svg class="flex-shrink-0 size-4 text-red-500"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" x2="12" y1="8" y2="12">
                                                </line>
                                                <line x1="12" x2="12.01" y1="16" y2="16">
                                                </line>
                                            </svg>
                                        </div>
                                    @enderror
                                </div>
                                @error('no_telp')
                                    <p class="text-xs text-red-600 mt-2" id="no_telp-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- End Form HP -->

                            <!-- Form Email -->
                            <div>
                                <label for="email" class="block text-sm mb-2">Email</label>
                                <div class="relative">
                                    <input type="email" id="email" wire:model="email"
                                        class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('email') border-red-500 @enderror"
                                        aria-describedby="email-error">
                                    @error('email')
                                        <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
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
                            <!-- End Form Email -->

                            <!-- Form Alamat -->
                            <div class="lg:col-span-2">
                                <label for="alamat" class="block text-sm mb-2">Alamat</label>
                                <div class="relative">
                                    <textarea id="alamat" wire:model="alamat"
                                        class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('alamat') border-red-500 @enderror"
                                        aria-describedby="alamat-error"></textarea>
                                    @error('alamat')
                                        <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
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
                                @error('alamat')
                                    <p class="text-xs text-red-600 mt-2" id="alamat-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- End Form Alamat -->

                            <!-- Form Customer -->
                            <div class="lg:col-span-2">
                                <label for="tipe_customer" class="block text-sm mb-2">Tipe Customer</label>
                                <div class="relative">
                                    <select id="tipe_customer" wire:model.live="tipe_customer"
                                        class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('tipe_customer') border-red-500 @enderror">
                                        <option value="" disabled>Pilih Tipe Customer</option>
                                        <option value="perusahaan">Perusahaan</option>
                                        <option value="perorangan">Perorangan</option>
                                    </select>
                                </div>
                                @error('tipe_customer')
                                    <p class="text-xs text-red-600 mt-2" id="tipe_customer-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- End Form Customer -->

                            <!-- Form Perusahaan -->
                            @if ($tipe_customer == 'perusahaan')
                                <div class="lg:col-span-2">
                                    <div class="flex justify-between items-center">
                                        <label for="perusahaan" class="block text-sm">Perusahaan</label>
                                        <span class="block mb-2 text-sm text-gray-500">Opsional</span>
                                    </div>
                                    <div class="relative">
                                        <input type="text" id="perusahaan" wire:model="perusahaan"
                                            class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none  @error('perusahaan') border-red-500 @enderror"
                                            aria-describedby="perusahaan-error">
                                        @error('perusahaan')
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
                                    @error('perusahaan')
                                        <p class="text-xs text-red-600 mt-2" id="perusahaan-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif
                            <!-- End Form Perusahaan -->

                            <!-- Form PW -->
                            <div>
                                <label for="hs-toggle-password" class="block text-sm mb-2">Password</label>
                                <div class="relative">
                                    <input id="hs-toggle-password" type="password" wire:model="password"
                                        class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('password') border-red-500 @enderror">
                                    <button type="button" data-hs-toggle-password='{"target": "#hs-toggle-password"}'
                                        class="absolute top-0 end-0 p-3.5 rounded-e-md">
                                        <svg class="flex-shrink-0 size-3.5 text-gray-400" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path class="hs-password-active:hidden" d="M9.88 9.88a3 3 0 1 0 4.24 4.24">
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
                                            <path class="hs-password-active:hidden" d="M9.88 9.88a3 3 0 1 0 4.24 4.24">
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

                            <!-- Form Foto -->
                            <div class="lg:col-span-2">
                                <div class="flex justify-between items-center">
                                    <label for="profile_img" class="block text-sm font-medium mb-2">Foto</label>
                                    <span class="block mb-2 text-sm text-gray-500">Opsional</span>
                                </div>
                                <div class="flex items-center space-x-6 border border-gray-200 p-3 rounded-lg">
                                    <div class="shrink-0">
                                        <img id='preview_img' class="h-16 w-16 object-cover rounded-full" wire:ignore
                                            src="{{ asset('assets/images/no-image.jpg') }}"
                                            alt="Current profile photo" />
                                    </div>
                                    <label class="block">
                                        <span class="sr-only">Choose profile photo</span>
                                        <input type="file" onchange="loadFile(event)" wire:model="profile_img"
                                            class="cursor-pointer block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-500 hover:file:bg-gray-100 file:cursor-pointer" />
                                    </label>
                                </div>
                            </div>
                            <!-- End Form Foto -->

                            <button type="submit" wire:loading.remove wire:target='profile_img, save'
                                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none lg:col-span-2">Register</button>

                            <button type="submit" wire:loading wire:loading.attr='disabled'
                                wire:target='profile_img, save'
                                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none lg:col-span-2">
                                <div
                                    class="animate-spin inline-block size-4 border-[3px] border-current border-t-transparent text-white rounded-full">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                Loading ...
                            </button>
                        </div>
                    </form>
                    <!-- End Form -->
                </div>
            </div>
    </div>
</div>
