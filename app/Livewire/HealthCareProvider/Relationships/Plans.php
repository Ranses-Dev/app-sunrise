<?php

namespace App\Livewire\HealthCareProvider\Relationships;

use App\Models\HealthcareProviderPlan;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Livewire\Forms\HealthCareProvider as HealthCareProviderForm;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;

class Plans extends Component
{
    use WithPagination, WithoutUrlPagination;
    public int $providerId;
    public bool $showModalPlan = false;
    public int $planId;
    public HealthCareProviderForm $form;
    public function mount($id)
    {
        $this->providerId = $id;
    }
    public function render()
    {
        return view('livewire.health-care-provider.relationships.plans');
    }
    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return HealthcareProviderPlan::whereHas('providers', function ($query) {
            $query->where('healthcare_provider_id', $this->providerId);
        })->paginate(pageName: 'plans-page');
    }

    public function showModal()
    {
        $this->showModalPlan = true;
    }
    public function hideModal()
    {
        $this->showModalPlan = false;
        $this->resetValidation();
        $this->reset(['planId', 'showModalPlan']);
    }

    #[Computed]
    public function unlinkPlans(): Collection
    {
        return  $this->form->unlinkPlans($this->providerId);
    }

    public function linkPlan()
    {
        $this->validate(
            [
                'planId' => 'required|exists:healthcare_provider_plans,id',
            ],
            [
                'planId.required' => 'Please select a plan.',
                'planId.exists' => 'The selected plan does not exist.',
            ]
        );
        $this->form->linkHealthCareProviderPlan($this->providerId, $this->planId);
        Flux::toast(position: 'top right', text: 'Your changes have been saved.', variant: 'success');
        $this->hideModal();
    }
    public function unlinkPlan($planId)
    {
        $this->form->unlinkHealthCareProviderPlan($this->providerId, $planId);
        Flux::toast(position: 'top right', text: 'Your changes have been saved.', variant: 'success');
        $this->hideModal();
    }
}
