<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = (int) $this->command->ask('Number of categories to be created?', 10);
        Category::factory()->count($count)->create();
        $this->command->info($count . ' categories have been created');
    }
}
