<?php

namespace Database\Factories;

use App\Models\ProductSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name;
        return [
            'title' => $name,
            'alias' => \App\Lib\TranslitStr::convert($name),
            'description' => $this->faker->text(250),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
