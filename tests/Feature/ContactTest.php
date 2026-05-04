<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contacts_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/dashboard/contacts');

        $response->assertOk();
        $response->assertViewIs('dashboard.contacts.index');
    }

    public function test_unauthenticated_user_cannot_access_contacts_page(): void
    {
        $response = $this->get('/dashboard/contacts');

        $response->assertRedirect('/login');
    }

    public function test_contact_can_be_created(): void
    {
        $user = User::factory()->create();

        $contactData = [
            'name' => 'John Doe',
            'email_address' => 'john@example.com',
            'contact' => '123456789',
        ];

        $response = $this
            ->actingAs($user)
            ->post('/dashboard/contacts', $contactData);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/dashboard/contacts');

        $this->assertDatabaseHas('contacts', [
            'name' => 'John Doe',
            'email_address' => 'john@example.com',
            'contact' => '123456789',
        ]);
    }

    public function test_contact_can_be_updated(): void
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'name' => 'Old Name',
            'email_address' => 'old@example.com',
            'contact' => '111111111',
        ]);

        $updatedData = [
            'name' => 'New Name',
            'email_address' => 'new@example.com',
            'contact' => '222222222',
        ];

        $response = $this
            ->actingAs($user)
            ->put("/dashboard/contacts/{$contact->id}", $updatedData);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/dashboard/contacts');

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'New Name',
            'email_address' => 'new@example.com',
            'contact' => '222222222',
        ]);
    }

    public function test_contact_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete("/dashboard/contacts/{$contact->id}");

        $response->assertRedirect('/dashboard/contacts');

        // Using soft deletes, so it should still be in the database but with a deleted_at timestamp
        $this->assertSoftDeleted('contacts', [
            'id' => $contact->id,
        ]);
    }

    public function test_contact_creation_requires_validation(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/dashboard/contacts', [
                'name' => '',
                'email_address' => 'not-an-email',
                'contact' => '123', // too short
            ]);

        $response->assertSessionHasErrors(['name', 'email_address', 'contact']);
    }

    public function test_contact_unique_validation(): void
    {
        $user = User::factory()->create();
        Contact::factory()->create([
            'email_address' => 'duplicate@example.com',
            'contact' => '999999999',
        ]);

        $response = $this
            ->actingAs($user)
            ->post('/dashboard/contacts', [
                'name' => 'Test',
                'email_address' => 'duplicate@example.com',
                'contact' => '999999999',
            ]);

        $response->assertSessionHasErrors(['email_address', 'contact']);
    }
}
