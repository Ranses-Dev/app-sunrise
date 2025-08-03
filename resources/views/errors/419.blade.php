<x-layouts.basic :title="$title ?? '419 Page Expired'">
    <main class="relative grid min-h-screen place-items-center bg-gradient-to-br from-orange-50 to-orange-100 px-6 py-24 sm:py-32 lg:px-8 overflow-hidden">
        <div class="pointer-events-none select-none absolute inset-0 flex items-center justify-center -z-10">
            <span class="text-[18rem] sm:text-[24rem] md:text-[32rem] font-extrabold text-orange-200 opacity-20 blur-sm drop-shadow-lg animate-pulse">
                419
            </span>
        </div>
        <div class="text-center space-y-6">
            <h2 class="text-6xl sm:text-7xl font-extrabold tracking-tight text-orange-700 drop-shadow-lg">Sunconnect</h2>
            <p class="text-2xl font-bold text-orange-600">419</p>
            <h1 class="text-4xl sm:text-6xl font-semibold tracking-tight text-gray-900">Page expired</h1>
            <p class="text-lg sm:text-xl text-gray-500">Your session has expired. Please refresh and try again.</p>
            <div class="mt-8 flex justify-center">
                <a href="{{ url()->previous() }}"
                   class="inline-block rounded-lg bg-orange-600 px-6 py-3 text-lg font-semibold text-white shadow-lg hover:bg-orange-700 transition focus:outline-none focus:ring-2 focus:ring-orange-400">
                    Go back
                </a>
            </div>
        </div>
    </main>
</x-layouts.basic>
