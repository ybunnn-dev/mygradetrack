<x-app-layout>
    @section('title', 'Metrics')
    <div class="min-h-screen bg-mainback flex flex-col">
        <div class="flex-1 overflow-y-auto">
            <div class="max-w-[90rem] mx-auto sm:px-4 lg:px-6 py-8 sm:py-10 lg:py-8">
                <!-- Responsive heading -->
                <h1 class="font-bold mb-6 text-xl sm:text-base md:text-2xl lg:text-3xl text-text_heavy">
                    Metrics
                </h1>
                
                <!-- Under development message - now perfectly centered -->
                <div class="bg-white rounded-lg p-8 text-center min-h-[80vh] h-[80dvh] flex items-center justify-center">
                    <div class="w-full max-w-md mx-auto">
                        <!-- Construction icon -->
                        <svg class="w-16 h-16 text-yellow-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"></path>
                        </svg>
                        
                        <!-- Message -->
                        <h2 class="text-2xl font-semibold text-gray-700 mb-2">Under Development</h2>
                        <p class="text-gray-500 mb-6">
                            Our metrics module is currently being built. Please check back soon for valuable insights and analytics!
                        </p>
                        
                        <!-- Progress bar -->
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 75%"></div>
                        </div>
                        <p class="text-sm text-gray-400">Development progress: 75%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>