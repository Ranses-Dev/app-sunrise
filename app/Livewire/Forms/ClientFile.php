<?php

namespace App\Livewire\Forms;

use App\Traits\ImageHandler;
use Livewire\Form;
use Livewire\WithFileUploads;
use App\Repositories\ClientFileRepositoryInterface as ClientFileRepository;
use App\Repositories\AttachmentTypeRepositoryInterface as AttachmentTypeRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ClientFile extends Form
{
    use WithFileUploads, ImageHandler;
    public ?int $id = null;
    public ?int $clientId = null;
    public ?int $attachmentTypeId = null;
    public string $fileName = "";
    public $file = null;
    public string $notes = "";
    public  $attachmentTypes = null;

    protected  ClientFileRepository $clientFileRepository;
    protected AttachmentTypeRepository $attachmentTypeRepository;

    public function  boot(ClientFileRepository $clientFileRepository, AttachmentTypeRepository $attachmentTypeRepository)
    {
        $this->attachmentTypeRepository = $attachmentTypeRepository;
        $this->clientFileRepository = $clientFileRepository;
    }

    public function rules(): array
    {
        return [
            'clientId' => ['required', 'integer', 'exists:clients,id'],
            'attachmentTypeId' => ['required', 'integer', 'exists:attachment_types,id'],
            'fileName' => [
                'required',
                'string',
                'max:255',
                Rule::unique('client_files', 'file_name')->where(function ($query) {
                    return $query->where('client_id', $this->clientId);
                })->ignore($this->id)
            ],
            'file' => [Rule::requiredIf(fn(): bool => !$this->id), 'nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx', 'max:2048'],
            'notes' => ['nullable', 'string', 'max:255'],
        ];
    }
    public function messages(): array
    {
        return [
            'clientId.required' => 'The client field is required.',
            'attachmentTypeId.required' => 'The attachment type field is required.',
            'fileName.required' => 'The file name field is required.',
            'fileName.unique' => 'The file name has already been taken for this client.',
            'file.required' => 'The file field is required.',
            'file.mimes' => 'The file must be a file of type: jpg, jpeg, png, pdf, doc, docx, xls, xlsx.',
            'file.max' => 'The file may not be greater than 2MB.',
            'notes.max' => 'The notes may not be greater than 255 characters.',
        ];
    }
    public function setData(?int $id = null)
    {
        if ($id) {
            $clientFile = $this->clientFileRepository->findById($id);
            if ($clientFile) {
                $this->id = $clientFile->id;
                $this->clientId = $clientFile->client_id;
                $this->attachmentTypeId = $clientFile->attachment_type_id;
                $this->fileName = $clientFile->file_name;
                $this->notes = $clientFile->notes;
            }
        }
    }
    public function save()
    {

        $uuid = Str::uuid();
        $this->validate($this->rules(), $this->messages());
        $data = [
            'client_id' => $this->clientId,
            'attachment_type_id' => $this->attachmentTypeId,
            'file_name' => $this->fileName,
            'notes' => $this->notes,
        ];
        if ($this->id) {
            if ($this->file) {

                $this->clientFileRepository->deleteFileIfExists($this->id);
                $name = $uuid . '.' . $this->file->getClientOriginalExtension();
                $this->file->storeAs(path: 'clients', name: $name, options: 'local');
                $data['file_path'] = $name;
            }
            $this->clientFileRepository->update($this->id, $data);
        } else {
            if ($this->file) {
                $name = $uuid . '.' . $this->file->getClientOriginalExtension();
                $this->file->storeAs(path: 'clients', name: $name, options: 'local');
                $data['file_path'] = $name;
            }
            $this->clientFileRepository->create($data);
        }
        $this->reset([
            
            'attachmentTypeId',
            'fileName',
            'file',
            'notes'
        ]);
    }
    public function getAttachmentTypes()
    {
        $this->attachmentTypes = $this->attachmentTypeRepository->getAll();
    }

    public function delete()
    {
        if ($this->id) {
            $this->clientFileRepository->delete($this->id);
        }
    }
}
