<!-- Card Section -->
<div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 mx-auto"><!-- Card -->
    <div class="bg-white rounded-xl shadow p-4 sm:p-7">
        <div class="mb-8 border-b pb-6">
            <h2 class="text-xl font-bold text-gray-800">
                Edit Profile
            </h2>
            <p class="text-sm text-gray-600">
                Manage your name, password and account settings.
            </p>
        </div>

        <form wire:submit.prevent='update'>
            <!-- Grid -->
            <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                <div class="sm:col-span-3">
                    <label class="inline-block text-sm text-gray-800 mt-2.5">
                        Photo
                    </label>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-9">
                    <div class="flex items-center gap-5">
                        <img class="inline-block size-16 rounded-full ring-2 ring-white object-cover" id="preview_img"
                            wire:ignore
                            src="{{ $profile->profile_img ? url('storage', $profile->profile_img) : asset('assets/images/no-image.jpg') }}"
                            alt="Image Description">
                        <div wire:loading.remove wire:target='profile_img'>
                            <label for="profile_img"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" x2="12" y1="3" y2="15" />
                                </svg>
                                Upload photo
                                <input wire:model='profile_img' type="file" id='profile_img' class="hidden"
                                    wire:loading.attr='disabled' onchange="loadFile(event)" />
                            </label>
                        </div>

                        <div wire:loading wire:target='profile_img'>
                            <label for="profile_img"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
                                <div
                                    class="animate-spin inline-block size-4 border-[3px] border-current border-t-transparent text-gray-800 rounded-full">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                Uploading ...
                            </label>
                        </div>

                        {{-- <div>
                            <button type="button"
                                class="py-2 px-3 text-sm font-medium rounded-lg border border-red-500 text-red-500 shadow-sm hover:bg-red-200 disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>

                            </button>
                        </div> --}}

                    </div>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-3">
                    <label for="name" class="inline-block text-sm text-gray-800 mt-2.5">
                        Nama Lengkap
                    </label>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-9">
                    <div class="sm:flex">
                        <input id="name" type="text" wire:model='name'
                            class="py-2 px-3 pe-11 block w-full border-b border-gray-200 text-sm rounded-lg focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                            placeholder="John Doe">
                    </div>
                    @error('name')
                        <p class="text-xs text-red-600 mt-2" id="name-error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- End Col -->

                <!-- Tmpt Lahir -->
                <div class="sm:col-span-3">
                    <label for="tempat_lahir" class="inline-block text-sm text-gray-800 mt-2.5">
                        Tempat Lahir
                    </label>
                </div>

                <div class="sm:col-span-9">
                    <input id="tempat_lahir" type="text" wire:model='tempat_lahir'
                        class="py-2 px-3 pe-11 block w-full border-b border-gray-200 text-sm rounded-lg focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="Banjarmasin">
                    @error('tempat_lahir')
                        <p class="text-xs text-red-600 mt-2" id="tempat_lahir-error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- End Tmpt Lahir -->

                <!-- Tgl Lahir -->
                <div class="sm:col-span-3">
                    <label for="tanggal_lahir" class="inline-block text-sm text-gray-800 mt-2.5">
                        Tanggal Lahir
                    </label>
                </div>

                <div class="sm:col-span-9">
                    <input id="tgl_lahir" type="date" wire:model='tgl_lahir'
                        class="border-gray-200 border-b text-gray-800 text-sm  rounded-lg focus:ring-orange-500 focus:border-orange-500 py-2 px-3 pe-11 block w-full"
                        placeholder="Pilih Tanggal Lahir">
                    @error('tgl_lahir')
                        <p class="text-xs text-red-600 mt-2" id="tgl_lahir-error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- End Tgl Lahir -->

                <!-- No hp -->
                <div class="sm:col-span-3">
                    <label for="no_telp" class="inline-block text-sm text-gray-800 mt-2.5">
                        No. HP
                    </label>
                </div>

                <div class="sm:col-span-9">
                    <input id="no_telp" type="number" wire:model='no_telp'
                        class="py-2 px-3 pe-11 block w-full border-gray-200 border-b text-sm rounded-lg focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="628 xx xxxx xxxx">
                    @error('no_telp')
                        <p class="text-xs text-red-600 mt-2" id="no_telp-error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- End No hp -->

                <!-- Email -->
                <div class="sm:col-span-3">
                    <label for="email" class="inline-block text-sm text-gray-800 mt-2.5">
                        Email
                    </label>
                </div>

                <div class="sm:col-span-9">
                    <input id="email" type="email" wire:model='email'
                        class="py-2 px-3 pe-11 block w-full border-gray-200 border-b text-sm rounded-lg focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="johndoe@email.com">
                    @error('email')
                        <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- End Email -->

                <!-- Alamat -->
                <div class="sm:col-span-3">
                    <label for="alamat" class="inline-block text-sm text-gray-800 mt-2.5">
                        Alamat
                    </label>
                </div>

                <div class="sm:col-span-9">
                    <textarea id="alamat" wire:model='alamat'
                        class="py-2 px-3 block w-full border-b border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="Jl. Sungai Andai"></textarea>
                    @error('alamat')
                        <p class="text-xs text-red-600 mt-2" id="alamat-error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- End Alamat -->

                <!-- Tipe -->
                <div class="sm:col-span-3">
                    <label for="tipe_customer" class="inline-block text-sm text-gray-800 mt-2.5">
                        Tipe
                    </label>
                </div>

                <div class="sm:col-span-9">
                    <select wire:model='tipe_customer' id="tipe_customer"
                        class="py-3 px-4 pe-11 block w-full border-b border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('tipe_customer') border border-red-500 @enderror">
                        <option selected disabled>Pilih Tipe Customer</option>
                        <option value="perorangan" {{ $profile->tipe_customer == 'perorangan' ? 'selected' : '' }}>
                            Perorangan</option>
                        <option value="perusahaan" {{ $profile->tipe_customer == 'perusahaan' ? 'selected' : '' }}>
                            Perusahaan</option>
                    </select>
                    @error('tipe_customer')
                        <p class="text-xs text-red-600 mt-2" id="tipe_customer-error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- End Tipe -->

                <!-- Perusahaan -->
                <div class="sm:col-span-3">
                    <label for="perusahaan" class="inline-block text-sm text-gray-800 mt-2.5">
                        Perusahaan
                    </label>
                    <div class="hs-tooltip inline-block">
                        <button type="button" class="hs-tooltip-toggle ms-1">
                            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path
                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                            </svg>
                        </button>
                        <span
                            class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible w-40 text-center z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm"
                            role="tooltip">
                            Kosongkan form input perusahaan jika customer perorangan.
                        </span>
                    </div>
                </div>

                <div class="sm:col-span-9">
                    <input id="perusahaan" type="text" wire:model='perusahaan'
                        class="py-2 px-3 pe-11 block w-full border-gray-200 border-b text-sm rounded-lg focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="PT. Gala Jaya Banjarmasin (Optional)">
                    @error('perusahaan')
                        <p class="text-xs text-red-600 mt-2" id="perusahaan-error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- End Perusahaan -->

                <div class="sm:col-span-12 bg-gray-50 border border-gray-200 text-sm text-gray-600 rounded-lg p-4 lg:mt-0 mt-3"
                    role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="flex-shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 16v-4"></path>
                                <path d="M12 8h.01"></path>
                            </svg>
                        </div>
                        <div class="flex-1 md:flex md:justify-between ms-2">
                            <p class="text-sm">
                                Lewati jika tidak ingin merubah password.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- PW -->
                <div class="sm:col-span-3">
                    <label for="af-account-password" class="inline-block text-sm text-gray-800 mt-2.5">
                        Password
                    </label>
                </div>

                <div class="sm:col-span-9">
                    <div class="space-y-2">
                        <div class="relative">
                            <input id="hs-toggle-password" type="password" wire:model="password"
                                class="py-2 px-3 pe-11 block w-full border-b border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('password') border border-red-500 @enderror"
                                placeholder="Password baru">
                            <button type="button" data-hs-toggle-password='{"target": "#hs-toggle-password"}'
                                class="absolute top-0 end-0 p-3.5 rounded-e-md">
                                <svg class="flex-shrink-0 size-3.5 text-gray-400" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
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
                                    <circle class="hidden hs-password-active:block" cx="12" cy="12"
                                        r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-600 mt-2" id="password-error">{{ $message }}</p>
                        @enderror

                        <div class="relative">
                            <input id="hs-toggle-password-confirmation" type="password"
                                wire:model="password_confirmation"
                                class="py-2 px-3 pe-11 block w-full border-b border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('password') border border-red-500 @enderror"
                                placeholder="Konfirmasi password baru">
                            <button type="button"
                                data-hs-toggle-password='{"target": "#hs-toggle-password-confirmation"}'
                                class="absolute top-0 end-0 p-3.5 rounded-e-md">
                                <svg class="flex-shrink-0 size-3.5 text-gray-400" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
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
                                    <circle class="hidden hs-password-active:block" cx="12" cy="12"
                                        r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- End PW -->

            </div>
            <!-- End Grid -->

            <div class="mt-5 flex justify-end gap-x-2">
                <a href="/"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                    Cancel
                </a>
                <button type="submit" wire:loading.remove wire:target='profile_img, update'
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none">
                    Save changes
                </button>

                <button type="submit" wire:loading wire:target='profile_img, update' wire:loading.attr='disabled'
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none">
                    <div
                        class="animate-spin inline-block size-4 border-[3px] border-current border-t-transparent text-white rounded-full">
                        <span class="sr-only">Loading...</span>
                    </div>
                    Loading ...
                </button>
            </div>
        </form>
    </div>
    <!-- End Card -->
</div>
<!-- End Card Section -->
