<x-layouts.basic :title="$title ?? 'Two Factor Settings'">
    <main
        class="relative grid min-h-screen place-items-center bg-gradient-to-br from-blue-50 to-blue-100 px-6 py-24 sm:py-32 lg:px-8 overflow-hidden">
        <div>


            <flux:card class="space-y-6">
                <div>
                    <flux:heading size="lg">Two Factor Settings</flux:heading>
                    <flux:separator />
                </div>
                @if (session('status') == 'two-factor-authentication-enabled')
                    <div class="mb-4 font-medium text-sm">
                        Please finish configuring two factor authentication below.
                    </div>
                    @php
                        $qrSvg = request()->user()->twoFactorQrCodeSvg();
                        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);
                    @endphp
                    <img src="{{ $qrBase64 }}" alt="Two Factor QR Code" class="mx-auto my-4 w-40 h-40" />
                    <form method="POST" action="/user/confirmed-two-factor-authentication" class="space-y-6">
                        @csrf
                        @if ($errors->any())
                            <flux:error name="code">
                            </flux:error>
                        @endif
                        <div class="mb-4">
                            <flux:label for="code">Code</flux:label>
                            <flux:input type="text" name="code" id="code" maxlength="6" pattern="\d{6}"
                                value="{{ old('code') }}" autocomplete="one-time-code" inputmode="numeric"
                                class="mt-1 block w-full" />
                        </div>
                        <flux:button type="submit" variant="primary" icon="check-badge" class="w-full">
                            Confirm
                        </flux:button>
                    </form>
                @endif
                @if (session('status') == 'two_factor_secret_message')
                    <div class="mb-4 font-medium text-sm">
                        You must enable two-factor authentication.
                    </div>
                @endif
                @if (session('status') == 'two-factor-authentication-disabled')
                    <div class="mb-4 font-medium text-sm">
                        Two factor authentication has been disabled.
                    </div>
                @endif
                @if (session('status') == 'two-factor-authentication-confirmed')
                    <div class="mb-4 font-medium text-sm">
                        Two factor authentication confirmed and enabled successfully.
                    </div>
                @endif
                @if (auth()->check())
                    @if(!auth()->user()->hasEnabledTwoFactorAuthentication() && !auth()->user()->two_factor_recovery_codes_app)
                        <form method="POST" action="/user/two-factor-authentication">
                            @csrf
                            <flux:button variant="primary" icon="arrow-right-start-on-rectangle" type="submit" class="w-full">
                                Activate
                            </flux:button>
                        </form>
                @endif
            </flux:card>

        </div>

    </main>
</x-layouts.basic>
