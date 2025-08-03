<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable
        class="bg-zinc-50 dark:bg-zinc-900 border-r rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
        <flux:brand href="#" logo="{{asset('logo.png')}}" name="SunConnect" class="dark:hidden" />
        <flux:brand href="#" logo="{{asset('logo.png')}}" name="SunConnect" class="hidden dark:flex" />
        <flux:navlist variant="outline">
            <flux:navlist.item icon="home" href="{{ route('dashboard') }}" :current="request()->routeIs('dashboard')"
                wire:navigate>
                Dashboard
            </flux:navlist.item>
            @persist('alerts-sidebar')
            <flux:navlist.group expandable :expanded="false" heading="Alerts">
                <livewire:components.badge-identifications-due />
                <livewire:components.badge-identifications-overdue />
                <livewire:components.badge-certifications-due>
                    <livewire:components.badge-certifications-overdue>
            </flux:navlist.group>
            @endpersist

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
