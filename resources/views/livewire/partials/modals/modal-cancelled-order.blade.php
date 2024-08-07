 <div id="hs-cancelled-order-modal"
     class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
     <div
         class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
         <div class="w-full flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto">
             <div class="flex justify-between items-center py-3 px-4 border-b">
                 <h3 class="font-bold text-gray-800">
                     Cancelled order ?
                 </h3>
                 <button type="button"
                     class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
                     data-hs-overlay="#hs-cancelled-order-modal">
                     <span class="sr-only">Close</span>
                     <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                         <path d="M18 6 6 18"></path>
                         <path d="m6 6 12 12"></path>
                     </svg>
                 </button>
             </div>
             <div class="p-4 overflow-y-auto">
                 <p class="text-gray-800">
                     Are you sure you want to cancel this order?
                     <br>
                     This can't be undone.
                 </p>
             </div>
             <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t">
                 <button type="button"
                     class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                     data-hs-overlay="#hs-cancelled-order-modal">
                     Close
                 </button>
                 <form wire:submit.prevent='cancel'>
                     <button type="submit" wire:loading.remove wire:target='cancel'
                         class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-500 text-white hover:bg-red-600 disabled:opacity-50 disabled:pointer-events-none">
                         Yes!
                     </button>
                     <div wire:loading wire:target='cancel'>
                         <button type="submit" wire:loading.attr='disabled'
                             class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-500 text-white hover:bg-red-600 disabled:opacity-50 disabled:pointer-events-none">
                             <div
                                 class="animate-spin inline-block size-4 border-[3px] border-current border-t-transparent text-white rounded-full">
                                 <span class="sr-only">Loading...</span>
                             </div>
                             Loading ...
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
