<x-layouts.basic :title="$title ?? 'Two Factor Authentication'">
    <main
        class="relative grid min-h-screen place-items-center bg-gradient-to-br from-blue-50 to-blue-100 px-6 py-24 sm:py-32 lg:px-8 overflow-hidden">
        <form method="POST" action="/two-factor-challenge">
            @csrf
        <flux:input name="code" label="Authentication Code" required autofocus autocomplete="one-time-code" />
            <flux:button variant="primary" icon="arrow-right-start-on-rectangle" type="submit" class="w-full">
                Activate
            </flux:button>
        </form>
    </main>
</x-layouts.basic>
