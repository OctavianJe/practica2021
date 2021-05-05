<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class TestSeeder
 *
 * @package Database\Seeders
 */
class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(50)
            ->has(
                Board::factory()
                    ->count(3)
                    ->has(
                        Task::factory()->count(10),
                        'tasks'
                    ),
                'createdBoards'
            )
            ->create();
    }
}
