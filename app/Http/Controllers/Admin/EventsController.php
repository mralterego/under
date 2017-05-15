<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\CMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Event;
use Carbon\Carbon;


class EventsController extends Controller
{

    public function index()
    {
        return view('admin.events');
    }


    /**
     *  Загрузка
     */
    public function upload(Request $request)
    {
        if (Input::file()){
            $extension = $request->image->extension();
            $destinationPath = public_path().config('conf.dirs.events');
            $name = rtrim(strtr(base64_encode($request->image->path()), '+/', '-_'), '=');
            $img = time().'_'.$name.".".$extension;
            $request->image->move($destinationPath, $img);

            return response()->json([
                "response" => config('conf.dirs.events').$img
            ]);

        } else {
            return response()->json([
                "response" => "There is no input file"
            ]);
        }
    }
}