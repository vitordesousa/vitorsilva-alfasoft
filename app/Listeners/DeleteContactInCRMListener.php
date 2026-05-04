<?php

namespace App\Listeners;

use app\Events\Contacts\ContactDeletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteContactInCRMListener
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
    public function handle(ContactDeletedEvent $event): void
    {
        // Aqui pode ser implementada a lógica para deletar o contato no CRM, utilizando o
        // $event->contactId para identificar qual contato deve ser deletado e enviando o Job para a fila de processamento.
    }
}
