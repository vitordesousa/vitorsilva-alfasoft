<?php

namespace App\Repositories;

use App\DTOs\StoreContactDTO;
use App\DTOs\UpdateContactDTO;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactRepository
{
    public function listAndFilter(
        int|null $page = 1,
        int|null $perPage = 10,
        string|null  $filter = null,
    ): LengthAwarePaginator
    {
        return Contact::query()
            ->when($filter, function (Builder $builder) use ($filter) {
                $builder->where(function (Builder $query) use ($filter) {
                    $filter = e($filter);
                    $query->where('name', 'like', "%{$filter}%")
                        ->orWhere('email_address', 'like', "%{$filter}%")
                        ->orWhere('contact', 'like', "%{$filter}%");
                });
            })
            ->orderBy('name')
            ->paginate($perPage, ['*'], 'page', $page);
    }


    public function create(StoreContactDTO $dto): array
    {
        return Contact::query()
            ->create($dto->toArray())
            ->refresh()
            ->toArray()
            ;
    }

    public function update(UpdateContactDTO $dto): array
    {
        $contact = Contact::query()
            ->findOrFail($dto->id);

        $contact->update($dto->toArray());

        return $contact->refresh()->toArray();
    }

    public function delete(string $contactId): void
    {
        Contact::query()
            ->findOrFail($contactId)
            ->delete();
    }
}
