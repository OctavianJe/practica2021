<?php

namespace App\Http\Controllers;

use App\Models\Board;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * Class BoardsController
 *
 * @package App\Http\Controllers
 */
class BoardsController extends Controller
{
    public function boards()
    {
        $user = Auth::user();
        
        if($user->role === 0)
        {
            $boards = Board::where("user_id" ,$user->id)->paginate(10);
        }
        else
        {
            $boards = DB::table('boards')->paginate(10);
        }
        
        return view("boards.index" ,[
            "boards"=> $boards
        ]);
    }

    /**
     * @param  Request  $request
     *
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function update(Request $request)
    {
        $board = Board::Where("id" ,$request->id)->first();
        $board->name = $request->newName;
        
        $board->save();

        return response()->json(["msg"=>"Board succesfully updated."]);
    }

    /**
     * @param  Request  $request
     *
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function delete(Request $request)
    {
        $board =  Board::Where("id" ,$request->id)->first();

        $board->delete();

        return response()->json(["msg"=>"Board succesfully deleted."]);
    }
}
=======
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class BoardController
 *
 * @package App\Http\Controllers
 */
class BoardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function boards()
    {
        /** @var User $user */
        $user = Auth::user();

        $boards = Board::with(['user', 'boardUsers']);

        if ($user->role === User::ROLE_USER) {
            $boards = $boards->where(function ($query) use ($user) {
                //Suntem in tabele de boards in continuare
                $query->where('user_id', $user->id)
                    ->orWhereHas('boardUsers', function ($query) use ($user) {
                        //Suntem in tabela de board_users
                        $query->where('user_id', $user->id);
                    });
            });
        }

        $boards = $boards->paginate(10);

        return view(
            'boards.index',
            [
                'boards' => $boards
            ]
        );
    }

    public function updateBoard($id)
    {

    }

    public function deleteBoard($id)
    {

    }

    /**
     * @param $id
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function board($id)
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

        $board = clone $boards;
        $board = $board->where('id', $id)->first();

        $boards = $boards->select('id', 'name')->get();

        if (!$board) {
            return redirect()->route('boards.all');
        }

        return view(
            'boards.view',
            [
                'board' => $board,
                'boards' => $boards
            ]
        );
    }
}
>>>>>>> upstream/master
