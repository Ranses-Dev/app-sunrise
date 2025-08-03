<flux:navlist.item  wire:navigate wire:current :current="request()->routeIs('clients-certifications-due.index')" badge="{{ $this->totalCertificationsDue }}" href="{{ route('clients-certifications-due.index') }}">
    Recertifications Due
</flux:navlist.item>
