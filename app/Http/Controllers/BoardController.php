<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\BoardUser;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
                'boards' => $boards,
                'userList' => User::select(['id', 'name'])->get()->toArray()
            ]
        );
    }

    /**
     * @param  Request  $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function updateBoard(Request $request, $id): JsonResponse
    {
        /** @var Board $board */
        $board = Board::find($id);

        /** @var User $user */
        $user = Auth::user();

        $error = '';
        $success = '';

        if ($board) {
            if ($board->user->id === $user->id || $user->role === User::ROLE_ADMIN) {
                $newBoardUsers = $request->get('boardUsers');
                $existingBoardUsers = [];

                $board->boardUsers()->get()->each(function ($boardUser) use ($newBoardUsers, &$existingBoardUsers) {
                    if (!in_array($boardUser->user_id, $newBoardUsers)) {
                        $boardUser->delete();
                    } else {
                        $existingBoardUsers[] = $boardUser->user_id;
                    }
                });

                $toSave = array_diff($newBoardUsers, $existingBoardUsers);

                foreach ($toSave as $userId) {
                    $boardUser = new BoardUser();
                    $boardUser->board_id = $board->id;
                    $boardUser->user_id = $userId;
                    $boardUser->save();
                }

                $board->name = $request->get('name');
                $board->save();
                $board->refresh();

                $success = 'Board saved';
            } else {
                $error = 'You don\'t have permission to edit this board!';
            }
        } else {
            $error = 'Board not found!';
        }

        return response()->json(['error' => $error, 'success' => $success, 'board' => $board]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function deleteBoard($id): JsonResponse
    {
        /** @var Board $board */
        $board = Board::find($id);

        /** @var User $user */
        $user = Auth::user();

        $error = '';
        $success = '';

        if ($board) {
            if ($board->user->id === $user->id || $user->role === User::ROLE_ADMIN) {
                $board->delete();

                $success = 'Board deleted';
            } else {
                $error = 'You don\'t have permission to delete this board!';
            }
        } else {
            $error = 'Board not found!';
        }

        return response()->json(['error' => $error, 'success' => $success]);
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

        $tasks = $board->tasks()->oldest()->paginate(10);

        $boardUsers = $board->boardUsers()->with('user')->get();

        return view(
            'boards.view',
            [
                'board' => $board,
                'boards' => $boards,
                'tasks' => $tasks,
                'boardUsers' => $boardUsers
            ]
        );
    }

    /**
     * @param  Request  $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function updateTask(Request $request, $id): JsonResponse
    {
        /** @var Task $task */
        $task = Task::find($id);

        /** @var User $user */
        $user = Auth::user();

        $boardUser = BoardUser::where('board_id', $task->board_id)->where('user_id', $user->id)->first();

        $error = '';
        $success = '';

        if ($task) {
            if ($boardUser) {
                $task->name = $request->get('name');
                $task->description = $request->get('description');
                $task->assignment = $request->get('assignment');
                $task->status = $request->get('status');
                $task->save();

                $success = 'Task saved';
            } else {
                $error = 'You don\'t have permission to edit this task!';
            }
        } else {
            $error = 'Task not found!';
        }

        return response()->json(['error' => $error, 'success' => $success, 'task' => $task]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function deleteTask($id): JsonResponse
    {
        /** @var Task $task */
        $task = Task::find($id);

        /** @var User $user */
        $user = Auth::user();

        $error = '';
        $success = '';

        if ($task) {
            if ($task->board->user->id === $user->id || $user->role === User::ROLE_ADMIN) {
                $task->delete();

                $success = 'Task deleted';
            } else {
                $error = 'You don\'t have permission to delete this task!';
            }
        } else {
            $error = 'Task not found!';
        }

        return response()->json(['error' => $error, 'success' => $success]);
    }
}
