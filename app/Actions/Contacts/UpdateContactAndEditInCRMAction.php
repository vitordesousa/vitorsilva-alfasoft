<?php

namespace App\Actions\Contacts;

use App\DTOs\UpdateContactDTO;
use App\Events\Contacts\ContactUpdatedEvent;
use App\Helpers\Strings;
use App\Repositories\ContactRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateContactAndEditInCRMAction
{
    public function __construct(protected ContactRepository $contactRepository)
    {
    }

    public function handle(UpdateContactDTO $dto): array
    {
        $this->validate($dto);

        return DB::transaction(function () use ($dto) {
            $contact = $this->contactRepository->update($dto);

            event(new ContactUpdatedEvent($contact));

            return $contact;
        });
    }

    protected function validate(UpdateContactDTO $dto): void
    {
        $contact = Strings::onlyNumbers($dto->contact);

        $validate = Validator::make(
            [
                'name' => $dto->name,
                'email_address' => $dto->email_address,
                'contact' => $contact
            ],
            [
                'name' => ['required', 'string', 'min:5', 'max:150'],
                'email_address' => ['required', 'email', 'string', 'max:150', Rule::unique('contacts', 'email_address')->whereNull('deleted_at')->ignore($dto->id)],
                'contact' => ['required', 'numeric', 'digits:9', Rule::unique('contacts', 'contact')->whereNull('deleted_at')->ignore($dto->id)],
            ]
        );

        if ($validate->fails()) {
            throw ValidationException::withMessages($validate->errors()->toArray());
        }

        $dto->contact = $contact;
    }
}
