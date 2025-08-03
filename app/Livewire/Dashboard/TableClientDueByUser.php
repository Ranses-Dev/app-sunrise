<?php

namespace App\Livewire\Dashboard;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use App\Repositories\UserRepositoryInterface as UserRepository;
use Livewire\Attributes\Computed;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class TableClientDueByUser extends Component
{
    use WithPagination, WithoutUrlPagination;
     protected UserRepository $userRepository;
    public function mount(  UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function render()
    {
        return view('livewire.dashboard.table-client-due-by-user');
    }
    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return $this->userRepository->getCertificationsDue()->paginate(perPage: 10, pageName: 'table-client-due-by-user');
    }
}
