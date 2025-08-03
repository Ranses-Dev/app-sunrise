<div class="bg-white rounded-xl shadow p-4 w-full ">
    <div class="mb-3 flex justify-between items-center">
        <h2 class="text-sm font-semibold text-gray-700">Clients Recertification Status</h2>
    </div>
    <a href="{{ route('clients-certifications-due.index') }}" wire:navigate>
        <div class="flex justify-between items-center px-3 py-1 mb-1 rounded bg-yellow-100">
            <span class="text-sm font-medium text-gray-700">Recertifications Due</span>
            <flux:badge variant="solid" color="amber">
                {{ $this->totalReCertificationsDue() }}
            </flux:badge>
        </div>
    </a>
    <a href="{{ route('clients-certifications-overdue.index') }}" wire:navigate>
        <div class="flex justify-between items-center px-3 py-1 mb-1 rounded bg-red-100">
            <span class="text-sm font-medium text-gray-700">Recertifications Overdue</span>
            <flux:badge variant="solid" color="red">
                {{ $this->totalReCertificationsOverdue() }}
            </flux:badge>
        </div>
</div>
</a>
