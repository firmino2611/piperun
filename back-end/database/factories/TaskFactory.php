<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('now', '+10 year');

        return [
            'description' => $this->faker->text(60),
            'responsible' => $this->faker->name,
            'user_id' => 1,
            'start_at' => (new Carbon($date))->format('Y-m-d'),
            'status' => false,
            'end_at' => (new Carbon($date))->addDays(1)->format('Y-m-d'),
            'type_id' => Type::factory()->create()->id
        ];
    }
}
