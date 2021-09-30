<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductSection;

class ProductSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductSection::factory()->count(10)->create();
    }
}
