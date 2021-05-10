<?php

namespace App\Http\Controllers;

use App\Models\Board;
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