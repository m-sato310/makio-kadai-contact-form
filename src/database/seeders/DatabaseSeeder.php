<?php

namespace Database\Seeders;

use Database\Factories\ContactFactory;
use Illuminate\Database\Seeder;
use App\Models\Contact;

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
        ]);

        Contact::factory()->count(35)->create();
    }
}
