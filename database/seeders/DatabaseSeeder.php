<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\PostFactory;
use Database\Factories\TagFactory;
use Database\Factories\VoiceFactory;
use Database\Factories\PostTagFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        PostFactory::new()->has(TagFactory::new()->count(3))->count(200)->create();
        VoiceFactory::new()->count(100)->create();
    }
}
