<?php

namespace App\Livewire\ProgramBranch;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\ProgramBranch as ProgramBranchForm;
use Flux\Flux;
use App\Repositories\ProgramRepositoryInterface;

#[Title('Create Program Branch')]
class Create extends Component
{
    protected ProgramRepositoryInterface $programRepository;
    public function boot(ProgramRepositoryInterface $programRepository)
    {
        $this->programRepository = $programRepository;
    }
    public ProgramBranchForm $form;
    public function booted()
    {
        $this->form->programs = $this->programRepository->getAll();
    }
    public function render()
    {
        return view('livewire.program-branch.create');
    }
    public function store()
    {

        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::CREATE_SUCCESS->value));
        return redirect()->route('program-branches.index');
    }
    public function storeAndNew()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::CREATE_SUCCESS->value));
    }
    public function cancel()
    {
        return redirect()->route('program-branches.index');
    }
}
