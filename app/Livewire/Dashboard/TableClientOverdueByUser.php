<?php

namespace App\Livewire\Dashboard;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use App\Repositories\UserRepositoryInterface as UserRepository;
use Livewire\Attributes\Computed;

class TableClientOverdueByUser extends Component
{
    protected UserRepository $userRepository;

    public function mount(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function render()
    {
        return view('livewire.dashboard.table-client-overdue-by-user');
    }

    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return $this->userRepository->getCertificationsOverdue()->paginate(perPage: 10, pageName: 'table-client-overdue-by-user');
    }
}
