<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Board;

**
 * Class BoardSeeder
 *
 * @package Models\Board
 */
class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Board::factory(5)->create();   
    }
}