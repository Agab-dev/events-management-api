<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventAttendee>
 */
class EventAttendeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected static $types = [
        'individual',
        'group'
    ];

    public function definition(): array
    {
        $selectedType = fake()->randomElement(static::$types);

        return [
            'type' => $selectedType,
            'number_of_attendees' => $selectedType === 'individual' ? 1 : fake()->numberBetween(2, 4)
        ];
    }
}
