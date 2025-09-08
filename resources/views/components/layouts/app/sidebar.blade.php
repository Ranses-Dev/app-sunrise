<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-transparent">
    <flux:sidebar sticky stashable class="bg-sky-100">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
        <div class="border-b-2 border-white  dark:border-gray-700">
            <a wire:navigate href="{{ route('dashboard') }}">
                <div class="  rounded-md flex flex-row items-center justify-center gap-3">
                    <img src="{{asset('logo.png')}}" class="dark:hidden w-18" />
                    <p class="font-thin text-blue-900 text-2xl">Sunconnect</p>
                </div>
            </a>
        </div>




        <img src="{{asset('logo.png')}}" class="hidden dark:flex" />
        <flux:navlist variant="outline">
            <flux:navlist.item class="text-gray-900" icon="home" href="{{ route('dashboard') }}"
                :current="request()->routeIs('dashboard')" wire:navigate>
                Dashboard
            </flux:navlist.item>
         

            <x-layouts.app.menu.items />
        </flux:navlist>
        <flux:spacer />

        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:profile name="{{ auth()->user()?->name }}" />
            <flux:menu>
                <flux:menu.item href="{{ route('settings.profile') }}" icon="user">Profile</flux:menu.item>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle">Logout
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:spacer />
        <flux:dropdown position="top" alignt="start">
            <flux:profile name="{{ auth()->user()?->name }}" />
            <flux:menu>
                <flux:menu.item href="{{ route('settings.profile') }}" icon="user">Profile</flux:menu.item>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle">Logout
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}


    @fluxScripts
    @persist('toast')
    <flux:toast />
    @endpersist
</body>

</html>
