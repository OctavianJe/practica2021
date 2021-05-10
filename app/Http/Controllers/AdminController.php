<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * Class AdminController
 *
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    public function users()
    {
        $users = DB::table('users')->paginate(10);

        return view(
            'users.index',[
                'users' => $users
            ]);
    }

    public function boards()
    {
        $boards = DB::table('boards')->paginate(10);

        return view(
            'boards.admin',[
                'boards' => $boards
            ]);
    }

    /**
     * @param  Request  $request
     *
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function update(Request $request)
    {   
        $user = User::Where("id" ,$request->id)->first();
        $user->role = $request->userRole;

        $user->save();

        return response()->json(["msg"=>"Succes" ,"usr"=>$request->userRole ,"mail"=>$request->userEmail]);
    }

    /**
     * @param  Request  $request
     *
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function delete(Request $request){

        $user = User::Where("id" ,$request->id)->first();

        $user->delete();
        
        return response()->json(["msg"=>"Succes" ,"usr"=>$user->id]);
    }
}
