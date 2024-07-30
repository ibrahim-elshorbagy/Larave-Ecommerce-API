<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $counter = 1;

        return [
            'title' => 'product ' . $this->numberToWord($counter++),
            'image' => 'https://picsum.photos/200/300',
            'description' => 'This is a description for ' . $this->numberToWord($counter) . '. ' . fake()->realText(100),
            'price' => fake()->randomFloat(2, 2, 5),
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }

    /**
     * Convert a number to its word representation.
     *
     * @param int $number
     * @return string
     */
    protected function numberToWord(int $number): string
    {
        $words = [
            1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five',
            6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten',
            11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen',
            15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 21 => 'twenty-one', 22 => 'twenty-two',
            23 => 'twenty-three', 24 => 'twenty-four', 25 => 'twenty-five',
            26 => 'twenty-six', 27 => 'twenty-seven', 28 => 'twenty-eight',
            29 => 'twenty-nine', 30 => 'thirty'
        ];

        return $words[$number] ?? 'unknown';
    }
}
