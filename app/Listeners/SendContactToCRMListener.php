<?php

namespace App\Listeners;

use App\Events\Contacts\ContactCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendContactToCRMListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ContactCreatedEvent $event): void
    {
        // Aqui pode ser implementada a lógica para enviar o contato para o CRM,
        // utilizando os dados do $event->contact para criar o contato no CRM e enviando o Job para a fila de processamento.
    }
}
