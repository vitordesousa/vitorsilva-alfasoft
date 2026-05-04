<?php

namespace Tests\Feature\Actions;

use App\Actions\Contacts\CreateContactAndSendToCRMAction;
use App\Actions\Contacts\DeleteContactAndSendToCRMAction;
use App\Actions\Contacts\UpdateContactAndEditInCRMAction;
use App\DTOs\StoreContactDTO;
use App\DTOs\UpdateContactDTO;
use App\Events\Contacts\ContactCreatedEvent;
use App\Events\Contacts\ContactDeletedEvent;
use App\Events\Contacts\ContactUpdatedEvent;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use ReflectionException;
use Tests\TestCase;

class ContactActionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws ReflectionException
     */
    public function test_create_contact_action_dispatches_event(): void
    {
        Event::fake();

        $dto = new StoreContactDTO([
            'name' => 'John Doe',
            'email_address' => 'john.actions@example.com',
            'contact' => '123456789',
        ]);

        $action = app(CreateContactAndSendToCRMAction::class);
        $result = $action->handle($dto);

        $this->assertDatabaseHas('contacts', [
            'email_address' => 'john.actions@example.com',
        ]);

        Event::assertDispatched(ContactCreatedEvent::class, function ($event) use ($result) {
            return $event->contact['id'] === $result['id'];
        });
    }

    public function test_update_contact_action_dispatches_event(): void
    {
        Event::fake();

        $contact = Contact::factory()->create([
            'name' => 'Original Name',
            'contact' => '111111111'
        ]);

        $dto = new UpdateContactDTO([
            'id' => $contact->id,
            'name' => 'Updated Name',
            'email_address' => $contact->email_address,
            'contact' => '999999999',
        ]);

        $action = app(UpdateContactAndEditInCRMAction::class);
        $result = $action->handle($dto);

        $this->assertEquals('Updated Name', $result['name']);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Updated Name',
            'contact' => '999999999'
        ]);

        Event::assertDispatched(ContactUpdatedEvent::class, function ($event) use ($contact) {
            return $event->contact['id'] === $contact->id;
        });
    }

    public function test_delete_contact_action_dispatches_event(): void
    {
        Event::fake();

        $contact = Contact::factory()->create();

        $action = app(DeleteContactAndSendToCRMAction::class);
        $action->handle($contact->id);

        $this->assertSoftDeleted('contacts', [
            'id' => $contact->id,
        ]);

        Event::assertDispatched(ContactDeletedEvent::class, function ($event) use ($contact) {
            return $event->contactId === $contact->id;
        });
    }
}
