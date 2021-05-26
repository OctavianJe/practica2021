<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

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
        /** @var User $user */
        $user = Auth::user();

        $boards = Board::query();

        if ($user->role === User::ROLE_USER) {
            $boards = $boards->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('boardUsers', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
            });
        }

        $tasksCount = $user->tasks()->count();
//        $tasks = Task::where('assignment', $user->id)->count();

        $adminsCount = User::where('role', User::ROLE_ADMIN)->count();

        $tasksDoneCount = Task::where('status', Task::STATUS_DONE)->count();
        $tasksInProgressCount = Task::where('status', Task::STATUS_IN_PROGRESS)->count();

        return view('dashboard.index',
            [
                'boardsCount' => $boards->count(),
                'tasksCount' => $tasksCount
            ]
        );
    }
}
