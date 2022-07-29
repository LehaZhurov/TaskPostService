<?php

namespace Database\Factories;

use App\Domain\Posts\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class TagFactory extends Factory
{
    protected $model = Tag::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "tag" => $this->faker->word(),
        ];
    }
}
