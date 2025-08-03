<flux:navlist.item wire:navigate wire:current :current="request()->routeIs('clients-certifications-overdue.index')"
    badge="{{ $this->totalCertificationsOverdue }}" href="{{ route('clients-certifications-overdue.index') }}">
    Recertifications Overdue
</flux:navlist.item>
