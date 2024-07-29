<div class="w-full min-h-screen max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section id="content">
        <div class="flex flex-col text-center py-24 px-4 sm:px-6 lg:px-8">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-24 text-red-500 justify-center w-full">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <h1 class="text-3xl font-bold text-gray-800 my-2">Your order has been cancelled!</h1>
            <p class="mt-3 text-gray-600">Dear {{ auth()->guard('customer')->user()->name }}, Your order
                {{ request()->route()->parameter('order_id') }} <br> was cancelled at your request.</p>
            <div class="mt-5 flex flex-col justify-center items-center gap-2 sm:flex-row sm:gap-3">
                <a class="w-full sm:w-auto py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-500 text-white hover:bg-red-600 disabled:opacity-50 disabled:pointer-events-none"
                    href="{{ route('order', auth()->guard('customer')->user()->id) }}">
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                    Back to Orders
                </a>
            </div>
        </div>
    </section>
</div>
