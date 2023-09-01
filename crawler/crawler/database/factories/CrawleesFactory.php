<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CrawleesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'url' => 'https://' . implode('.', $this->faker->words($this->faker->numberBetween(0, 4))),
            'contents' => json_encode([
                'title' => $this->faker->text(10),
                'description' => $this->faker->text(20),
                'body' => $this->faker->paragraph(),
            ]),
            'screenshot_path' => '/' . implode('/', $this->faker->words($this->faker->numberBetween(0, 4)))
        ];
    }
}
