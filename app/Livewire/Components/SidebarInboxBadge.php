<?php

namespace App\Livewire\Components;

use App\Models\Client;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SidebarInboxBadge extends Component
{

    public function render()
    {
        return view('livewire.components.sidebar-inbox-badge');
    }
    #[Computed]
    public function inboxCount(): int
    {
        return Client::whereDate('re_certification_date', '<=', Carbon::now()->addDays(90))->count();
    }
}
