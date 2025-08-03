<?php

namespace App\Livewire\Forms;


use Livewire\Form;
use App\Repositories\ClientPhoneNumberRepositoryInterface as ClientPhoneNumberRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

class ClientPhoneNumber extends Form
{
    public ?int $id = null;
    public ?int $clientId = null;
    public ?string $phoneNumber = null;
    public ?string $notes = null;

    protected ClientPhoneNumberRepository $clientPhoneNumberRepository;

    public function boot(ClientPhoneNumberRepository $clientPhoneNumberRepository)
    {
        $this->clientPhoneNumberRepository = $clientPhoneNumberRepository;
    }

    public function rules(): array
    {
        return [
            'clientId' => ['required', 'integer', 'exists:clients,id'],
            'phoneNumber' => ['required', 'string', 'max:255', Rule::unique('client_phone_numbers', 'phone_number')->where('client_id', $this->clientId)->ignore($this->id)],
            'notes' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->clientPhoneNumberRepository->findById($id);
            if ($result) {
                $this->id = $result->id;
                $this->clientId = $result->client_id;
                $this->phoneNumber = $result->phone_number;
                $this->notes = $result->notes;
            }
        }
    }

    public function save()
    {
        $this->validate();
        $data = [
            'client_id' => $this->clientId,
            'phone_number' => $this->phoneNumber,
            'notes' => $this->notes,
        ];
        if ($this->id) {
            $this->clientPhoneNumberRepository->update($this->id, $data);
        } else {
            $this->clientPhoneNumberRepository->create($data);
        }
        $this->reset(['id', 'phoneNumber', 'notes']);
    }

    public function delete()
    {
        if ($this->id) {
            $this->clientPhoneNumberRepository->delete($this->id);
        }
    }
    public function getFiltered(string $search): LengthAwarePaginator
    {
        return $this->clientPhoneNumberRepository->getFiltered($search)->paginate(pageName: 'client-phone-numbers-page');
    }
}
