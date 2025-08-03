<x-layouts.basic :title="$title ?? '404 Not Found'">
    <main class="relative grid min-h-screen place-items-center bg-gradient-to-br from-blue-50 to-blue-100 px-6 py-24 sm:py-32 lg:px-8 overflow-hidden">
        <!-- Improved background watermark -->
        <div class="pointer-events-none select-none absolute inset-0 flex items-center justify-center -z-10">
            <span class="text-[18rem] sm:text-[24rem] md:text-[32rem] font-extrabold text-blue-200 opacity-20 blur-sm drop-shadow-lg animate-pulse">
                404
            </span>
        </div>
        <div class="text-center space-y-6">
            <h2 class="text-6xl sm:text-7xl font-extrabold tracking-tight text-blue-700 drop-shadow-lg">Sunconnect</h2>
            <p class="text-2xl font-bold text-blue-600">404</p>
            <h1 class="text-4xl sm:text-6xl font-semibold tracking-tight text-gray-900">Page not found</h1>
            <p class="text-lg sm:text-xl text-gray-500">Sorry, we couldn’t find the page you’re looking for.</p>
            <div class="mt-8 flex justify-center">
                <a href="{{ url('/') }}"
                   class="inline-block rounded-lg bg-blue-600 px-6 py-3 text-lg font-semibold text-white shadow-lg hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Back to home
                </a>
            </div>
        </div>
    </main>
</x-layouts.basic>
