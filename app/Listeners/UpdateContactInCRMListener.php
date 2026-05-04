<?php

namespace App\Listeners;

use App\Events\Contacts\ContactUpdatedEvent;
use App\Models\Contact;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateContactInCRMListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public Contact $contact)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ContactUpdatedEvent $event): void
    {
        // Aqui pode ser implementada a lógica para atualizar o contato no CRM, utilizando os dados do $event->contact
        // para identificar qual contato deve ser atualizado e enviando o Job para a fila de processamento.
    }
}
