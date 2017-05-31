<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Message;

class UsersController extends Controller
{

    public function users(){

        $users = [];
        if (Auth::user()->exists == true){
            $users = User::get();
        }
        return response()->json([
            "response" => $users
        ]);
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            "keyword" => "filled|required",
        ]);
        $keyword = $request->input('keyword');
        $user = User::where('name', 'LIKE', '%'.$keyword.'%')->get();
        return response()->json([
            "response" => $user
        ]);
    }

    public function messages()
    {
        $getter = "";
        $message = "";
        if (Auth::user()){
            $getter = Auth::user()->name;
            $message = Message::where('getter', 'LIKE', '%'.$getter.'%')->where('isComment', false)->where('isRead', false)->orderBy('created_at', 'desc')->get();
        }
        return response()->json([
            "response" => $message
        ]);
    }

}