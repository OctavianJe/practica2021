<?php

namespace App\Services;

use App\Models\Board;
use App\Models\BoardUser;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Class BoardService
 *
 * @package App\Services
 */
class BoardService
{
    /**
     * @param $user
     *
     * @return LengthAwarePaginator
     */
    public function getBoards($user)
    {
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

        return $boards->paginate(10);
    }

    /**
     * @param  Request  $request
     * @param $userId
     *
     * @return Board
     */
    public function addBoard(Request $request, $userId): Board
    {
        $board = new Board();

        $board->name = $request->get('name');
        $board->user_id = $userId;

        $board->save();

        $boardUser = new BoardUser();
        $boardUser->board_id = $board->id;
        $boardUser->user_id = $userId;
        $boardUser->save();

        if ($request->has('boardUsers')) {
            foreach ($request->get('boardUsers') as $newUserId) {
                if ((int)$userId !== (int)$newUserId) {
                    $boardUser = new BoardUser();
                    $boardUser->board_id = $board->id;
                    $boardUser->user_id = $newUserId;
                    $boardUser->save();
                }
            }
        }

        $board->refresh();

        return $board;
    }
}
