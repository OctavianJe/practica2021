<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\BoardUser;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class TaskFactory
 *
 * @package Database\Factories
 */
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
     */
    public function definition(): array
    {
        return [
            'board_id' => Board::factory(),
            'name' => $this->faker->text(20),
            'description' => $this->faker->text,
            'status' => $this->faker->randomElement([Task::STATUS_CREATED, Task::STATUS_IN_PROGRESS, Task::STATUS_DONE]),
            'assignment' => $this->faker->randomElement([
                User::factory(), null, User::inRandomOrder()->first()->id, User::inRandomOrder()->first()->id, User::inRandomOrder()->first()->id
            ])
        ];
    }

    /**
     * @return TaskFactory
     */
    public function configure(): TaskFactory
    {
        return $this->afterCreating(function (Task $task) {
            if ($task->assignment) {
                BoardUser::firstOrCreate([
                    'board_id' => $task->board_id,
                    'user_id' => $task->assignment
                ]);
            }
        });
    }
}
