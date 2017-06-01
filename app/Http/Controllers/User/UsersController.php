<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
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

    public function updateImage(Request $request)
    {
        $this->validate($request, [
            "id" => "filled|required",
            "avatar" => "filled|required",
        ]);
        $id = $request->input('id');
        $avatar = $request->input('avatar');
        # сохраняем новую новость в бд
        $out =  User::where('id', (int)($id))->update([
            'avatar' => $avatar,
        ]);
        return response()->json([
            "response" => $out
        ]);
    }
    /**
     *  Загрузка изображения
     */
    public function upload(Request $request)
    {
        if (Input::file()){
            $extension = $request->image->extension();
            $destinationPath = public_path().config('conf.dirs.avatars');
            $name = rtrim(strtr(base64_encode($request->image->path()), '+/', '-_'), '=');
            $img = time().'_'.$name.".".$extension;
            $request->image->move($destinationPath, $img);

            return response()->json([
                "response" => config('conf.dirs.avatars').$img
            ]);

        } else {
            return response()->json([
                "response" => "There is no input file"
            ]);
        }
    }

}