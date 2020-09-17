<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Type;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $months = [
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => 9,
            10 => 10,
            11 => 11,
            12 => 12
        ];
        Task::factory()
            ->count(10)
            ->state(function () use ($months) {
                $rand = array_rand($months, 1);
                unset($months[$rand]);
                return [
                    'start_at' => Carbon::now()->addMonths($rand),
                    'end_at' => Carbon::now()->addMonths($rand)->addDays(1),
                    'type_id' => Type::all()->random(1)->first()->id
                ];
            })
            ->create();
    }
}
