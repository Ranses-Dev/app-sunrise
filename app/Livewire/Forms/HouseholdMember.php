<?php

namespace App\Livewire\Forms;


use App\Enums\PaymentFrequency;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Form;
use App\Repositories\GenderRepositoryInterface;
use App\Repositories\HouseholdRelationTypeRepositoryInterface;
use App\Repositories\EthnicityRepositoryInterface;
use App\Repositories\HouseholdMemberRepositoryInterface;
use Illuminate\Validation\Rule;

class HouseholdMember extends Form
{
    public ?int $id = null;
    public ?int $clientId = null;
    public ?string $firstName = null;
    public ?string $lastName = null;
    public ?string $ssn = null;
    public ?string $dob = null;
    public ?int $genderId = null;
    public ?int $householdRelationTypeId = null;
    public ?int $ethnicityId = null;
    public $genders = [];
    public $householdRelationTypes = [];
    public $ethnicities = [];
    //For Payments
    public bool $editAddPayment = false;
    public array $paymentAmounts = [];
    public  float|null $paymentAmount = 0;
    public string|null $frequencyPayment = null;
    protected HouseholdMemberRepositoryInterface $householdMemberRepository;
    protected GenderRepositoryInterface $genderRepository;
    protected HouseholdRelationTypeRepositoryInterface $householdRelationTypeRepository;
    protected EthnicityRepositoryInterface $ethnicityRepository;

    public function boot(
        HouseholdMemberRepositoryInterface $householdMemberRepository,
        GenderRepositoryInterface $genderRepository,
        HouseholdRelationTypeRepositoryInterface $householdRelationTypeRepository,
        EthnicityRepositoryInterface $ethnicityRepository
    ) {
        $this->householdMemberRepository = $householdMemberRepository;
        $this->genderRepository = $genderRepository;
        $this->householdRelationTypeRepository = $householdRelationTypeRepository;
        $this->ethnicityRepository = $ethnicityRepository;
    }
    public function rules(): array
    {
        return [
            'clientId' => ['required', 'integer', 'exists:clients,id'],
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date', 'before:today'],
            'ssn' => ['required', 'string', 'regex:/^\d{3}-?\d{2}-?\d{4}$/', function ($attribute, $value) {
                if (strlen($value) !== 11 || !preg_match('/^\d{3}-\d{2}-\d{4}$/', $value)) {
                    $this->addError($attribute, 'The SSN must be in the format XXX-XX-XXXX.');
                }
                $validate = $this->householdMemberRepository->validateUniqueSSN($value, $this->clientId, $this->id);
                if (!$validate) {
                    $this->addError($attribute, 'The SSN must be unique for the house hold and client.');
                }
            }],
            'genderId' => ['required', 'integer', 'exists:genders,id'],
            'householdRelationTypeId' => ['required', 'integer', 'exists:household_relation_types,id'],
            'ethnicityId' => ['required', 'integer', 'exists:ethnicities,id'],
            'paymentAmounts' => ['nullable', 'array', function ($attribute, $value) {
                if ($this->editAddPayment && empty($value)) {
                    $this->addError($attribute, 'The payments amount field is required when adding a payment.');
                } else {
                    foreach ($value as $amount) {
                        if (!is_numeric($amount) || $amount <= 0) {
                            $this->addError($attribute, 'Each payment amount must be a positive number.');
                        }
                    }
                }
            }],
            'frequencyPayment' => ['nullable', 'string', Rule::requiredIf($this->editAddPayment), Rule::in(PaymentFrequency::values())],
        ];
    }
    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->householdMemberRepository->findById($id);
            if ($result) {
                $this->id = $result->id;
                $this->clientId = $result->client_id;
                $this->firstName = $result->first_name;
                $this->lastName = $result->last_name;
                $this->dob = $result->dob;
                $this->ssn = $result->ssn;
                $this->genderId = $result->gender_id;
                $this->householdRelationTypeId = $result->household_relation_type_id;
                $this->ethnicityId = $result->ethnicity_id;
                if ($result->frequency_payment && !empty($result->payment_amounts)) {
                    $this->editAddPayment = true;
                    $this->frequencyPayment = $result->frequency_payment;
                    $this->paymentAmounts = $result->payment_amounts;
                }
            }
        }
    }
    public function save()
    {
        $this->validate();
        $data = [
            'client_id' => $this->clientId,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'dob' => $this->dob,
            'gender_id' =>  $this->genderId,
            'household_relation_type_id' => $this->householdRelationTypeId,
            'ethnicity_id' => $this->ethnicityId,
            'frequency_payment' => $this->frequencyPayment,
            'payment_amounts' => $this->paymentAmounts,
            'ssn' => $this->ssn,
        ];
        if ($this->id) {
            $this->householdMemberRepository->update($this->id, $data);
        } else {
            $this->householdMemberRepository->create($data);
        }
        $this->reset(['id', 'firstName', 'lastName','ssn', 'dob', 'genderId', 'householdRelationTypeId', 'ethnicityId', 'income']);
    }
    public function delete()
    {
        if ($this->id) {
            $this->householdMemberRepository->delete($this->id);
        }
    }
    public function getFiltered(string $search): LengthAwarePaginator
    {
        return $this->householdMemberRepository->getFiltered($this->clientId,$search)
            ->paginate(pageName: 'household-members-page');
    }
    public function getGenders()
    {
        $this->genders = $this->genderRepository->getAll();
    }
    public function getHouseholdRelationTypes()
    {
        $this->householdRelationTypes = $this->householdRelationTypeRepository->getAll();
    }
    public function getEthnicities()
    {
        $this->ethnicities = $this->ethnicityRepository->getAll();
    }
    public function addPayment()
    {
        $this->validate([
            'frequencyPayment' => ['required', 'string', Rule::in(\App\Enums\PaymentFrequency::values())],
            'paymentAmount' => ['required', 'numeric', 'min:1'],
        ]);

        $this->paymentAmounts[] = $this->paymentAmount;
        $this->paymentAmount = 0;
    }
    public function deletePayment(float $amount)
    {
        if (($key = array_search($amount, $this->paymentAmounts)) !== false) {
            unset($this->paymentAmounts[$key]);
        }
    }
}
