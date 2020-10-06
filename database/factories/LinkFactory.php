<?php

namespace Database\Factories;

use App\Models\Link;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LinkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Link::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'label'       => $this->faker->sentence,
            'slug'        => $this->faker->unique()->slug,
            'full_link'   => $this->faker->unique()->url,
            'description' => $this->faker->paragraph
        ];
    }

    public function private()
    {
        return $this->state( [
            'secret' => Str::random( 6 ),
        ] );
    }
}
