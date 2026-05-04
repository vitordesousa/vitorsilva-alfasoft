<?php

namespace App\Actions\Contacts;

use App\Events\Contacts\ContactDeletedEvent;
use App\Repositories\ContactRepository;
use Illuminate\Support\Facades\DB;

class DeleteContactAndSendToCRMAction
{
    public function __construct(protected ContactRepository $contactRepository)
    {
    }

    public function handle(string $contactId): void
    {
        DB::transaction(function () use ($contactId) {
            $this->contactRepository->delete($contactId);

            event(new ContactDeletedEvent($contactId));
        });
    }
}
