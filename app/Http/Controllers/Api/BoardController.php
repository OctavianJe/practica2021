<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Services\BoardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class BoardController
 *
 * @package App\Http\Controllers
 */
class BoardController extends ApiController
{
    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function all(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::guard('api')->user();

        $boardService = new BoardService();

        $boards = $boardService->getBoards($user);

        return $this->successResponse(['boards' => $boards]);
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function addBoard(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'boardUsers' => 'nullable|array',
            'boardUsers.*' => 'exists:users,id'
        ], [
            'boardUsers.array' => 'Please send an array of users assigned to board',
            'boardUsers.*.exists' => 'This user doesn\'t exist.',
        ]);

        if ($validator->fails()) {
            return $this->userErrorResponse($validator->getMessageBag()->toArray());
        }

        $boardService = new BoardService();

        $board = $boardService->addBoard($request, $user->id);

        return $this->successResponse(['board' => $board]);
    }
}
