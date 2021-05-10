<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

**
 * Class TaskSeeder
 *
 * @package Models\Task
 */
class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::factory(5)->create();
    }
}