<?php

namespace App\Actions\Contacts;

use App\DTOs\StoreContactDTO;
use App\Events\Contacts\ContactCreatedEvent;
use App\Helpers\Strings;
use App\Repositories\ContactRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CreateContactAndSendToCRMAction
{
    public function __construct(protected ContactRepository $contactRepository)
    {
    }

    public function handle(StoreContactDTO $dto): array
    {
        $this->validate($dto);

        $dto->name = str($dto->name)->title()->toString();

        return DB::transaction(function () use ($dto) {
            $contact = $this->contactRepository->create($dto);

            event(new ContactCreatedEvent($contact));

            return $contact;
        });
    }

    protected function validate(StoreContactDTO $dto): void
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
                'email_address' => ['required', 'email', 'string', 'max:150', Rule::unique('contacts', 'email_address')->whereNull('deleted_at')],
                'contact' => ['required', 'numeric', 'digits:9', Rule::unique('contacts', 'contact')->whereNull('deleted_at')],
            ]
        );

        if ($validate->fails()) {
            throw ValidationException::withMessages($validate->errors()->toArray());
        }

        $dto->contact = $contact;
    }
}
