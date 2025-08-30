<?php

namespace App\Livewire\Forms;

use App\Models\Client;
use App\Models\Program;
use Illuminate\Support\Collection;
use Livewire\Form;
use App\Repositories\MealContractTypeRepositoryInterface;
use App\Repositories\DeliveryCostRepositoryInterface;
use App\Repositories\FoodCostRepositoryInterface;
use App\Repositories\ProgramDeliveryCostRepositoryInterface;
use App\Repositories\TerminationReasonRepositoryInterface;
use App\Repositories\ContractMealRepositoryInterface;
use App\Repositories\ClientRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;

class ContractMeal extends Form
{
    public ?int $id = null;
    public ?int $clientId = null;
    public ?int $programBranchId = null;
    public ?int $deliveryCostId = null;
    public ?int $foodCostId = null;
    public ?int $programDeliveryCostId = null;
    public ?int $clientServiceSpecialistId = null;
    public ?int $terminationReasonId = null;
    public ?bool $isActive = true;
    public ?string $recertificationDate = null;
    public ?string $notes = null;
    public ?string $code = null;

    public array $filters = [
        'search',
        'clientServiceSpecialistId',
        'programBranchId'
    ];


    public Collection $programBranches;
    public Collection $deliveryCosts;
    public Collection $foodCosts;
    public Collection $programDeliveryCosts;
    public Collection $terminationReasons;
    public Collection $clientServiceSpecialists;
    protected DeliveryCostRepositoryInterface $deliveryCostRepository;
    protected FoodCostRepositoryInterface $foodCostRepository;
    protected ProgramDeliveryCostRepositoryInterface $programDeliveryCostRepository;
    protected TerminationReasonRepositoryInterface $terminationReasonRepository;
    protected ContractMealRepositoryInterface $contractMealRepository;
    protected ClientRepositoryInterface $clientRepository;
    public function boot(
        DeliveryCostRepositoryInterface $deliveryCostRepository,
        FoodCostRepositoryInterface $foodCostRepository,
        ProgramDeliveryCostRepositoryInterface $programDeliveryCostRepository,
        TerminationReasonRepositoryInterface $terminationReasonRepository,
        ContractMealRepositoryInterface $contractMealRepository,
        ClientRepositoryInterface $clientRepository
    ) {

        $this->deliveryCostRepository = $deliveryCostRepository;
        $this->foodCostRepository = $foodCostRepository;
        $this->programDeliveryCostRepository = $programDeliveryCostRepository;
        $this->terminationReasonRepository = $terminationReasonRepository;
        $this->contractMealRepository = $contractMealRepository;
        $this->clientRepository = $clientRepository;
    }


    public function rules(): array
    {
        return [
            'clientId' => ['required', 'integer', 'exists:clients,id',   function ($attribute, $value, $fail) {
                $exists = \App\Models\ContractMeal::where('client_id', $value)
                    ->where('is_active', true)
                    ->where('id', '!=', $this->id)
                    ->exists();
                if ($exists) {
                    $fail('The client already has an active meal contract.');
                }
            },],
            'clientServiceSpecialistId' => ['required',  function ($attribute, $value, $fail) {
                if ($this->programBranchId) {
                    $exists = $this->clientRepository->getClientServiceSpecialistsByProgramBranch($this->programBranchId)
                        ->contains('id', $value);
                    if (!$exists) {
                        $fail('The selected client service specialist does not belong to the program of the meal contract type.');
                    }
                } else {
                    $fail('The meal contract type must be selected to validate the client service specialist.');
                }
            },],
            'programBranchId' => ['required', 'integer', function ($attribute, $value, $fail) {
                if (!Program::with('branches')->find(3)->branches->contains('id', $value)) {
                    $fail('Please select a valid meal contract type.');
                }
            }],
            'deliveryCostId' => ['required', 'integer', 'exists:delivery_costs,id'],
            'foodCostId' => ['required', 'integer', 'exists:food_costs,id'],
            'programDeliveryCostId' => ['required', 'integer', 'exists:program_delivery_costs,id'],
            'terminationReasonId' => ['nullable', 'integer', 'exists:termination_reasons,id', Rule::requiredIf(!$this->isActive), function ($attribute, $value, $fail) {
                if ($this->isActive && $value !== null) {
                    $fail('The termination reason must be empty when the contract is active.');
                }
            },],
            'isActive' => ['boolean'],
            'recertificationDate' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'code' => ['nullable', 'string', 'max:15', Rule::unique('contract_meals')->ignore($this->id)],
        ];
    }
    public function messages(): array
    {

        return [
            'clientId.required' => 'The client is required.',
            'clientId.exists' => 'The selected client does not exist.',
            'clientServiceSpecialistId.required' => 'The client service specialist is required.',
            'programBranchId.required' => 'The program branch is required.',
            'deliveryCostId.required' => 'The delivery cost is required.',
            'foodCostId.required' => 'The food cost is required.',
            'programDeliveryCostId.required' => 'The program delivery cost is required.',
            'terminationReasonId.exists' => 'The selected termination reason does not exist.',
            'recertificationDate.required' => 'The recertification date is required.',
            'notes.string' => 'Notes must be a string.',
            'code.max' => 'The code may not be greater than 15 characters.',
            'code.unique' => 'The code has already been taken.'
        ];
    }

    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->contractMealRepository->findById($id);
            if ($result) {
                $this->id = $result->id;
                $this->clientId = $result->client_id;
                $this->programBranchId = $result->program_branch_id;
                $this->loadClientServiceSpecialists();
                $this->clientServiceSpecialistId = $result->client_service_specialist_id;
                $this->deliveryCostId = $result->delivery_cost_id;
                $this->foodCostId = $result->food_cost_id;
                $this->programDeliveryCostId = $result->program_delivery_cost_id;
                $this->terminationReasonId = $result->termination_reason_id;
                $this->isActive = $result->is_active;
                $this->recertificationDate = optional($result->recertification_date)->format('Y-m-d');
                $this->notes = $result->notes;
                $this->code = $result->code;
            }
        }
    }
    public function save()
    {
        $this->validate($this->rules(), $this->messages());
        $data = [
            'client_id' => $this->clientId,
            'program_branch_id' => $this->programBranchId,
            'client_service_specialist_id' => $this->clientServiceSpecialistId,
            'delivery_cost_id' => $this->deliveryCostId,
            'food_cost_id' => $this->foodCostId,
            'program_delivery_cost_id' => $this->programDeliveryCostId,
            'termination_reason_id' => $this->terminationReasonId,
            'is_active' => $this->isActive,
            'recertification_date' => $this->recertificationDate ? date('Y-m-d', strtotime($this->recertificationDate)) : null,
            'notes' => $this->notes,
            'code' => $this->code,
        ];
        if ($this->id) {
            $this->contractMealRepository->update($this->id, $data);
        } else {
            $this->contractMealRepository->create($data);
        }
        $this->reset(['id', 'clientId', 'mealContractTypeId', 'deliveryCostId', 'foodCostsId', 'programDeliveryCostId', 'terminationReasonId', 'isActive', 'recertificationDate', 'notes']);
    }
    public function delete()
    {
        if ($this->id) {
            $this->contractMealRepository->delete($this->id);
        }
    }
    public function loadProgramBranches()
    {
        $this->programBranches = $this->contractMealRepository->getProgramBranches();
    }
    public function loadDeliveryCosts()
    {
        $this->deliveryCosts = $this->deliveryCostRepository->getAll();
    }
    public function loadFoodCosts()
    {
        $this->foodCosts = $this->foodCostRepository->getAll();
    }
    public function loadProgramDeliveryCosts()
    {
        $this->programDeliveryCosts = $this->programDeliveryCostRepository->getAll();
    }
    public function loadTerminationReasons()
    {
        $this->terminationReasons = $this->terminationReasonRepository->getAll();
    }
    public function loadClientServiceSpecialists()
    {
        $this->clientServiceSpecialists = $this->clientRepository->getClientServiceSpecialistsByProgram(config('services.programs.meals_id'));
    }
    public function getFiltered(string $search): Builder
    {
        return $this->contractMealRepository->getFiltered($this->filters)->with([
            'client',
            'mealContractType',
            'deliveryCost',
            'foodCost',
            'programDeliveryCost',
            'terminationReason',
            'clientServiceSpecialist'
        ]);
    }

    public function getClients(array $filters = []): Builder
    {
        return $this->clientRepository->getFiltered($filters);
    }

    public function getClientById(int $clientId): Client|null
    {
        return $this->clientRepository->findById($clientId);
    }

    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return $this->contractMealRepository->getFiltered($this->filters)->paginate(pageName: 'contract-meals-page');
    }
}
