<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Board;
use App\Models\Task;
use App\Models\User;

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
        $user = Auth::user();
        $tasks = Task::get()->count();
        $users= User::get()->count();
        
        if ($user->role == User::ROLE_ADMIN) {
            $boards = Board::get()->count();
        }else if ($user->role === User::ROLE_USER){
            $boards = Board::with(['boardUsers']);
            $boards = $boards->where(function ($query) use ($user) {
               
                $query->where('user_id', $user->id)
                    ->orWhereHas('boardUsers', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
            })->get()->count();
        }
        
        return view('dashboard.index',['boards'=> $boards,'tasks' =>$tasks, 'users' => $users]);
    }
}
