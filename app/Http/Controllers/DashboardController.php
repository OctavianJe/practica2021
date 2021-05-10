<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Models\Board;
use App\Models\User;
use App\Models\Task;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $users_number = User::all()->count();
        $boards_number = Board::all()->count();
        $tasks_number = Task::all()->count();

        return view('dashboard.index' ,[
                "users_number" => $users_number ,
                "boards_number" => $boards_number ,
                "tasks_number" => $tasks_number
        ]);
    }
}
