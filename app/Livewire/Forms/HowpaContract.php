<?php

namespace App\Livewire\Forms;

use App\Enums\RecentLivingSituation;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use App\Repositories\HowpaContractRepositoryInterface;
use App\Repositories\ClientRepositoryInterface;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\ClientPhoneNumberRepositoryInterface;
use App\Repositories\EmergencyContactRepositoryInterface;
use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use App\Models\EmergencyContact;
use Illuminate\Support\Facades\Log;

class HowpaContract extends Form
{
    public  ?string $search = null;
    public ?int $id = null;
    public ?int $clientId = null;
    public ?int $emergencyContactOneId = null;
    public ?int $emergencyContactTwoId = null;
    public ?Client $client = null;
    public ?int $clientPhoneNumberId = null;
    public ?Collection $clientPhoneNumbers = null;
    public ?SupportCollection $recentLivingSituations = null;
    public ?int $cityId = null;
    public ?Collection $cities = null;
    public ?int $programBranchId = null;
    public ?string $date = null;
    public ?int $numberBedroomsReq = null;
    public ?int $numberBedroomsApproved = null;
    public ?string $recentLivingSituation = null;
    public ?string $recentLivingSituationNotes = null;
    public bool $ownsRealEstate = false;
    public bool $hasSavings = false;
    public ?float $savingsBalance = null;
    public bool $hasCheckingAccount = false;
    public ?float $checkingAvgBalanceSixMonths = null;
    public ?string $assetsNotes = null;
    public bool $outsideSupport = false;
    public ?string $outsideSupportExplanation = null;
    public bool $committedFraudOrAskedToRepay = false;
    public ?string $fraudExplanation = null;
    public bool $hasAids = false;
    public bool $howpaPriorTo2023 = false;
    public bool $currentlyReceivingOtherAid = false;
    public bool $agreedStatements = false;
    public ?Collection $emergencyContacts = null;
    public ?int $emergencyContactId = null;
    public ?EmergencyContact $emergencyContactOne = null;
    public ?EmergencyContact $emergencyContactTwo = null;
    protected HowpaContractRepositoryInterface $howpaContractRepository;
    protected ClientRepositoryInterface $clientRepository;
    protected CityRepositoryInterface $cityRepository;
    protected ClientPhoneNumberRepositoryInterface $clientPhoneNumberRepository;
    protected EmergencyContactRepositoryInterface $emergencyContactRepository;
    public function boot(
        HowpaContractRepositoryInterface $howpaContractRepository,
        ClientRepositoryInterface $clientRepository,
        CityRepositoryInterface $cityRepository,
        ClientPhoneNumberRepositoryInterface $clientPhoneNumberRepository,
        EmergencyContactRepositoryInterface $emergencyContactRepository
    ) {
        $this->howpaContractRepository = $howpaContractRepository;
        $this->clientRepository = $clientRepository;
        $this->cityRepository = $cityRepository;
        $this->clientPhoneNumberRepository = $clientPhoneNumberRepository;
        $this->emergencyContactRepository = $emergencyContactRepository;
    }
    public function rules()
    {
        return  [
            'clientId' => 'required|exists:clients,id',
            'cityId' => 'required|exists:cities,id',
            'phoneNumberId' => 'required|exists:client_phone_numbers,id',
            'programBranchId' => 'required|exists:program_branches,id',
            'date' => 'required|date',
            'numberBedroomsReq' => 'required|integer|min:0',
            'numberBedroomsApproved' => 'required|integer|min:0',
            'recentLivingSituation' => ['required', 'string', Rule::in(collect(RecentLivingSituation::cases())->pluck('name')->toArray())],
            'recentLivingSituationNotes' => ['nullable', 'string', Rule::excludeIf($this->recentLivingSituation !== RecentLivingSituation::OTHER->name), Rule::requiredIf($this->recentLivingSituation === RecentLivingSituation::OTHER->name), 'max:255'],
            'ownsRealEstate' => 'boolean',
            'hasSavings' => 'boolean',
            'savingsBalance' => 'nullable|numeric|min:0',
            'hasCheckingAccount' => 'boolean',
            'checkingAvgBalanceSixMonths' => 'nullable|numeric|min:0',
            'assetsNotes' => ['nullable', 'string', 'max:255'],
            'outsideSupport' => 'boolean',
            'outsideSupportExplanation' => ['nullable', 'string', 'max:255', Rule::excludeIf(!$this->outsideSupport), Rule::requiredIf($this->outsideSupport)],
            'committedFraudOrAskedToRepay' => 'boolean',
            'fraudExplanation' => ['nullable', 'string', 'max:255'],
            'hasAids' => 'boolean',
            'howpaPriorTo2023' => 'boolean',
            'currentlyReceivingOtherAid' => 'boolean',
            'agreedStatements' => 'boolean',
            'emergencyContactOneId' => 'nullable|exists:emergency_contacts,id',
            'emergencyContactTwoId' => 'nullable|exists:emergency_contacts,id',
        ];
    }
    public function messages(): array
    {
        return [

            'clientId.required' => 'Client is required.',
            'clientId.exists' => 'Selected client does not exist.',

            'cityId.required' => 'City is required.',
            'cityId.exists' => 'Selected city does not exist.',
            'phoneNumberId.required' => 'Phone number is required.',
            'phoneNumberId.exists' => 'Selected phone number does not exist.',
            'programBranchId.required' => 'Program branch is required.',
            'programBranchId.exists' => 'Selected program branch does not exist.',

            'date.required' => 'Date is required.',
            'date.date' => 'Date must be a valid date.',

            'numberBedroomsReq.required' => 'Number of bedrooms requested is required.',
            'numberBedroomsReq.integer' => 'Number of bedrooms requested must be an integer.',
            'numberBedroomsReq.min' => 'Number of bedrooms requested cannot be negative.',

            'numberBedroomsApproved.required' => 'Number of bedrooms approved is required.',
            'numberBedroomsApproved.integer' => 'Number of bedrooms approved must be an integer.',
            'numberBedroomsApproved.min' => 'Number of bedrooms approved cannot be negative.',

            'recentLivingSituation.required' => 'Recent living situation is required.',
            'recentLivingSituation.in' => 'Selected recent living situation is invalid.',

            'recentLivingSituationNotes.required_if' => 'Please provide details for the recent living situation.',
            'recentLivingSituationNotes.max' => 'Recent living situation notes cannot exceed 255 characters.',

            'ownsRealEstate.boolean' => 'Owns real estate must be true or false.',

            'hasSavings.boolean' => 'Has savings must be true or false.',
            'savingsBalance.numeric' => 'Savings balance must be a valid number.',
            'savingsBalance.min' => 'Savings balance cannot be negative.',

            'hasCheckingAccount.boolean' => 'Has checking account must be true or false.',
            'checkingAvgBalanceSixMonths.numeric' => 'Average checking balance must be a valid number.',
            'checkingAvgBalanceSixMonths.min' => 'Average checking balance cannot be negative.',

            'assetsNotes.max' => 'Assets notes cannot exceed 255 characters.',

            'outsideSupport.boolean' => 'Outside support must be true or false.',
            'outsideSupportExplanation.required_if' => 'Please explain the outside support.',
            'outsideSupportExplanation.max' => 'Outside support explanation cannot exceed 255 characters.',

            'committedFraudOrAskedToRepay.boolean' => 'Fraud history must be true or false.',
            'fraudExplanation.max' => 'Fraud explanation cannot exceed 255 characters.',

            'hasAids.boolean' => 'This field must be true or false.',
            'howpaPriorTo2023.boolean' => 'This field must be true or false.',
            'currentlyReceivingOtherAid.boolean' => 'This field must be true or false.',

            'agreedStatements.boolean' => 'You must agree to the statements.',
            'emergencyContactOneId.exists' => 'Selected emergency contact one does not exist.',
            'emergencyContactTwoId.exists' => 'Selected emergency contact two does not exist.',
        ];
    }
    public function setData(?int $id = null)
    {
        if ($id) {
            $result = $this->howpaContractRepository->findById($id);
            if ($result) {
                $this->id = $result->id;
                $this->clientId = $result->client_id;
                $this->programBranchId = $result->program_branch_id;
                $this->date = $result->date;
                $this->numberBedroomsReq = $result->number_bedrooms_req;
                $this->numberBedroomsApproved = $result->number_bedrooms_approved;
                $this->recentLivingSituation = $result->recent_living_situation;
                $this->recentLivingSituationNotes = $result->recent_living_situation_notes;
                $this->ownsRealEstate = $result->owns_real_estate;
                $this->hasSavings = $result->has_savings;
                $this->savingsBalance = $result->savings_balance;
                $this->hasCheckingAccount = $result->has_checking_account;
                $this->checkingAvgBalanceSixMonths = $result->checking_avg_balance_six_months;
                $this->assetsNotes = $result->assets_notes;
                $this->outsideSupport = $result->outside_support;
                $this->outsideSupportExplanation = $result->outside_support_explanation;
                $this->committedFraudOrAskedToRepay = $result->committed_fraud_or_asked_to_repay;
                $this->fraudExplanation = $result->fraud_explanation;
                $this->hasAids = $result->has_aids;
                $this->howpaPriorTo2023 = $result->howpa_prior_to_2023;
                $this->currentlyReceivingOtherAid = $result->currently_receiving_other_aid;
                $this->agreedStatements = $result->agreed_statements;
                $this->emergencyContactOneId = $result->emergency_contact_one_id;
                $this->emergencyContactTwoId = $result->emergency_contact_two_id;
            }
        }
    }

    public function save()
    {
        $this->validate($this->rules(), $this->messages());
        $data = [
            'client_id' => $this->clientId,
            'program_branch_id' => $this->programBranchId,
            'date' => $this->date,
            'number_bedrooms_req' => $this->numberBedroomsReq,
            'number_bedrooms_approved' => $this->numberBedroomsApproved,
            'recent_living_situation' => $this->recentLivingSituation,
            'recent_living_situation_notes' => $this->recentLivingSituationNotes,
            'owns_real_estate' => $this->ownsRealEstate,
            'has_savings' => $this->hasSavings,
            'savings_balance' => $this->savingsBalance,
            'has_checking_account' => $this->hasCheckingAccount,
            'checking_avg_balance_six_months' => $this->checkingAvgBalanceSixMonths,
            'assets_notes' => $this->assetsNotes,
            'outside_support' => $this->outsideSupport,
            'outside_support_explanation' => $this->outsideSupportExplanation,
            'committed_fraud_or_asked_to_repay' => $this->committedFraudOrAskedToRepay,
            'fraud_explanation' => $this->fraudExplanation,
            'has_aids' => $this->hasAids,
            'howpa_prior_to_2023' => $this->howpaPriorTo2023,
            'currently_receiving_other_aid' => $this->currentlyReceivingOtherAid,
            'agreed_statements' => $this->agreedStatements,
            'emergency_contact_one_id' => $this->emergencyContactOneId,
            'emergency_contact_two_id' => $this->emergencyContactTwoId,
        ];
        if ($this->id) {
            $this->howpaContractRepository->update($this->id, $data);
        } else {
            $this->howpaContractRepository->create($data);
        }
        $this->reset();
    }
    public function delete()
    {
        if ($this->id) {
            $this->howpaContractRepository->delete($this->id);
        }
    }
    #[Computed]
    public function result(): LengthAwarePaginator
    {
        return $this->howpaContractRepository->getFiltered($this->search)->paginate(pageName: 'howpa_contracts');
    }
    public function findClientBySsn(string $ssn): ?Client
    {
        $this->client = $this->clientRepository->findBySsn($ssn);
        if ($this->client) {
            $this->clientId = $this->client->id;
        }
        if (!$this->client) {
            session()->flash('ssnSearch', 'Client not found for the provided SSN.');
        }
        $this->getCities();
        $this->getClientPhoneNumbers();
        $this->getEmergencyContacts();
        return $this->client;
    }

    public function getCities()
    {
        $this->reset(['cityId']);
        $this->cities = $this->cityRepository->getAll();
    }
    public function getClientPhoneNumbers()
    {
        $this->reset(['clientPhoneNumberId', 'clientPhoneNumbers']);
        if ($this->clientId) {
            $this->clientPhoneNumbers = $this->clientPhoneNumberRepository->getAllByClientId($this->clientId);
        }
    }

    public function getRecentLivingSituations()
    {
        $this->recentLivingSituations = collect(RecentLivingSituation::cases());
    }

    public function getEmergencyContacts()
    {
        $this->emergencyContacts = $this->emergencyContactRepository->getFiltered(null, $this->clientId)
            ->when($this->emergencyContactOne, function ($query) {
                $query->where('id', '!=', $this->emergencyContactOne->id);
            })
            ->when($this->emergencyContactTwo, function ($query) {
                $query->where('id', '!=', $this->emergencyContactTwo->id);
            })
            ->get();
    }
    public function getEmergencyContactOne()
    {
        $this->validate([
            'emergencyContactId' => 'required|exists:emergency_contacts,id',
        ]);
        $this->emergencyContactOne = $this->emergencyContactRepository->findById($this->emergencyContactId);
        $this->reset(['emergencyContactId']);
        $this->getEmergencyContacts();
    }
    public function getEmergencyContactTwo()
    {
        $this->validate([
            'emergencyContactId' => 'required|exists:emergency_contacts,id',
        ]);
        $this->emergencyContactTwo = $this->emergencyContactRepository->findById($this->emergencyContactId);
        $this->reset(['emergencyContactId']);
        $this->getEmergencyContacts();
    }
}
