<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    #[\Override] public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email_address' => $this->faker->email(),
            'contact' => $this->faker->numberBetween(100000000, 999999999),
        ];
    }
}
