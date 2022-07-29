<?php

namespace Database\Factories;

use App\Domain\Posts\Models\PostTag;
use Database\Factories\PostFactory;
use Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class PostTagFactory extends Factory
{
    protected $model = PostTag::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'post_id'=>PostFactory::new(),
            'tag_id'=>TagFactory::new(),
        ];
    }
}
