
<x-layouts.basic :title="$title ?? 'Verification Notice'">
    <main class="relative grid min-h-screen place-items-center bg-gradient-to-br from-blue-50 to-blue-100 px-6 py-24 sm:py-32 lg:px-8 overflow-hidden">
        <div class="pointer-events-none select-none absolute inset-0 flex items-center justify-center -z-10">
            <span class="text-[18rem] sm:text-[24rem] md:text-[32rem] font-extrabold text-blue-200 opacity-20 blur-sm drop-shadow-lg animate-pulse">
                @
            </span>
        </div>
        <div class="text-center space-y-6">
            <h2 class="text-6xl sm:text-7xl font-extrabold tracking-tight text-blue-700 drop-shadow-lg">Sunconnect</h2>
            <svg class="mx-auto mb-4 h-16 w-16 text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-.659 1.591l-7.091 7.091a2.25 2.25 0 01-3.182 0L3.909 8.584A2.25 2.25 0 013.25 6.993V6.75" />
            </svg>
            <h1 class="text-4xl sm:text-5xl font-semibold tracking-tight text-gray-900">Check your email</h1>
            <p class="text-lg sm:text-xl text-gray-600">
                We've sent a verification link to your email address.<br>
                Please check your inbox and click the link to verify your account.
            </p>
            <div class="mt-8 flex justify-center">
                <a href="{{ url('/') }}"
                   class="inline-block rounded-lg bg-blue-600 px-6 py-3 text-lg font-semibold text-white shadow-lg hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Go Dashboard
                </a>
            </div>
        </div>
    </main>
</x-layouts.basic>
