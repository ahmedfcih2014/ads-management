<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\Advertiser;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ad>
 */
class AdFactory extends Factory
{
    protected $model = Ad::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'advertiser_id' => 1,
            'type' => rand(0,1) == 0 ? 'free' : 'paid',
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'category_id' => 1,
            'start_date' => $this->faker->date
        ];
    }
}
