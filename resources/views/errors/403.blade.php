<x-layouts.basic :title="$title ?? '403 Forbidden'">
    <main
        class="relative grid min-h-screen place-items-center bg-gradient-to-br from-red-50 to-red-100 px-6 py-24 sm:py-32 lg:px-8 overflow-hidden">
        <!-- Background watermark -->
        <div class="pointer-events-none select-none absolute inset-0 flex items-center justify-center -z-10">
            <span
                class="text-[18rem] sm:text-[24rem] md:text-[32rem] font-extrabold text-red-200 opacity-20 blur-sm drop-shadow-lg animate-pulse">
                403
            </span>
        </div>
        <div class="text-center space-y-6">
            <h2 class="text-6xl sm:text-7xl font-extrabold tracking-tight text-red-700 drop-shadow-lg">Sunconnect</h2>
            <p class="text-2xl font-bold text-red-600">403</p>
            <h1 class="text-4xl sm:text-6xl font-semibold tracking-tight text-gray-900">Access denied</h1>
            <p class="text-lg sm:text-xl text-gray-500">You don’t have permission to view this page.</p>
            <div class="mt-8 flex justify-center">
                <a href="{{ url('/') }}"
                    class="inline-block rounded-lg bg-red-600 px-6 py-3 text-lg font-semibold text-white shadow-lg hover:bg-red-700 transition focus:outline-none focus:ring-2 focus:ring-red-400">
                    Back to home
                </a>
            </div>
        </div>
    </main>
</x-layouts.basic>
