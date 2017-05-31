<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Message;

class MessagesController extends Controller
{

    public function create(Request $request)
    {
        $this->validate($request, [
            "author" => "filled|required",
            "getter" => "filled|required",
            "content" => "filled|required",
        ]);
        $author = $request->input('author');
        $getter = $request->input('getter');
        $content = stripslashes(strip_tags($request->input('content')));
        $item = [
            "content" => $content,
            "author" => $author,
            "getter" => $getter,
            "isComment" => false,
            "isRead" =>  false,
        ];
        $out = Message::create($item);
        return response()->json([
            'response' => $out
        ]);
    }

    public function messages(Request $request)
    {

    }
}