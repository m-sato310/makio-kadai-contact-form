<?php

namespace Database\Seeders;

use Database\Factories\ContactFactory;
use Illuminate\Database\Seeder;
use App\Models\Contact;
use Illuminate\Broadcasting\Channel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            ContactSeeder::class,
            ChannelSeeder::class
        ]);
    }
}
