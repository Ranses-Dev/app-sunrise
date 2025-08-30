<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased
            bg-linear-to-b to-sky-500 via-sky-100 from-yellow-100
            dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10 ">
            <div class="flex border-2 p-4 rounded-2xl bg-white/20 border-white  w-full max-w-sm flex-col gap-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium " wire:navigate>
                    <span class="flex h-40 w-40 mb-1 items-center justify-center rounded-md">
                        <x-app-logo-icon class="size-9 fill-current   dark:text-white" />
                      <img src="{{ asset('logo.png') }}" alt="{{ config('app.name', 'Sunnconnect') }}" class="w-full max-w-md h-auto rounded-md" />


                </a>
                <div class="flex flex-col gap-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
