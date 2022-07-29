<?php

namespace Database\Factories;
use Database\Factories\PostFactory;
use App\Domain\Posts\Models\Voice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */


class VoiceFactory extends Factory
{

    protected $model = Voice::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "voices" => $this->faker->randomElement([-1, 1]),
            'post_id' => PostFactory::new(),
            'user_id' => $this->faker->numberBetween(1, 99)
        ];
    }
}
