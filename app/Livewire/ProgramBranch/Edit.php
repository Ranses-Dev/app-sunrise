<?php

namespace App\Livewire\ProgramBranch;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Repositories\ProgramRepositoryInterface;
use App\Livewire\Forms\ProgramBranch as ProgramBranchForm;
use Flux\Flux;

#[Title('Edit Program Branch')]
class Edit extends Component
{
    protected ProgramRepositoryInterface $programRepository;
    public ProgramBranchForm $form;
    public function boot(ProgramRepositoryInterface $programRepository)
    {
        $this->programRepository = $programRepository;
    }
    public function booted()
    {
        $this->form->programs = $this->programRepository->getAll();
    }
    public function mount(int $id)
    {

        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.program-branch.edit');
    }
    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        return redirect()->route('program-branches.index');
    }
    public function cancel()
    {
        return redirect()->route('program-branches.index');
    }
}
