<?php

namespace App\Livewire\Forms;

use App\Repositories\AttachmentTypeRepositoryInterface;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AttachmentType extends Form
{
    public ?int $id = null;
    public string $name = "";
    public string $description = "";

    protected AttachmentTypeRepositoryInterface $attachmentTypeRepository;
    public function boot(AttachmentTypeRepositoryInterface $attachmentTypeRepository)
    {
        $this->attachmentTypeRepository = $attachmentTypeRepository;
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('attachment_types')->ignore($this->id)],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->attachmentTypeRepository->findById($id);
            if ($result) {
                $this->id = $result->id;
                $this->name = $result->name;
                $this->description = $result->description;
            }
        }
    }
    public function save()
    {
        $this->validate();
        $data = [
            'name' => $this->name,
            'description' => $this->description,
        ];
        if ($this->id) {
            $this->attachmentTypeRepository->update($this->id, $data);
        } else {
            $this->attachmentTypeRepository->create($data);
        }
        $this->reset(['id', 'name', 'description']);
    }
    public function delete()
    {
        if ($this->id) {
            $this->attachmentTypeRepository->delete($this->id);
        }
    }
}
