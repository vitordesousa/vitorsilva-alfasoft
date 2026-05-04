<?php

namespace App\DTOs;

use App\DTOs\BaseDTO;

class UpdateContactDTO extends BaseDTO
{
    public string $id;

    public string $name;

    public string $email_address;

    public string $contact;
}
