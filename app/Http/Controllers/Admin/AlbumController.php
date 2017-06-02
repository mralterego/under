<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\CMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\Album;
use Carbon\Carbon;


class AlbumController extends Controller
{
    public function index()
    {
        return view('admin.album');
    }

    public function albumsList()
    {

    }

    public function item($id)
    {
        $id = Album::where('id', (int)($id)) -> value('id');

        # если нет id -> 404
        if ($id == false){
            abort(404);
        }

        # забираем массив параметров событий
        $album_params = Album::where('id', $id) -> get();

        $audio = json_decode($album_params[0]['audio'], true);
        $tags = json_decode($album_params[0]['tags'], true);
 
        return response()->json([
            "response" => $audio
        ]);

    }

    public function create(Request $request)
    {
        $this->validate($request, [
            "title" => "filled|required",
            "description" => "filled|required",
            "poster" => "filled|required",
            "audio" => "filled",
            "tags" => "filled",
            "published" => "filled",
        ]);
        $title = trim(strip_tags($request -> input('title')));
        $description = $request -> input('description');
        $poster = $request -> input('poster');
        $tags = $request->input('tags');
        $audio = $request->input('audio');
        $published = $request -> input('published') === "true" ? true : false;

        $item = [
            "title" => $title,
            "description" => $description,
            "poster" => $poster,
            "tags" => $tags,
            "author" => Auth::user()->name,
            "audio" => $audio,
            "published" => $published,
        ];
        $out = Album::create($item);

        return response()->json([
            "response" => $out
        ]);

    }
    public function update()
    {

    }

    public function uploadAudio(Request $request)
    {
        if (Input::file()){
            $file = $request->file('audio');
            $dirname = rtrim(strtr(base64_encode(Auth::user()->name), '+/', '-_'), '=');

            $destinationPath = public_path().config('conf.dirs.audio').$dirname;
            $isDir = CMS::createDir($destinationPath);
            if ($isDir){
                $ext = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $name = rtrim(strtr(base64_encode($name), '+/', '-_'), '=');
                $audio = '_'.$name.".".$ext;
                $request->file('audio')->move($destinationPath, $audio);

                return response()->json([
                    "response" => [
                        "name" => $file->getClientOriginalName(),
                        "path" => config('conf.dirs.audio').$dirname."/".$audio,
                    ]
                ]);

            } else {
                return response()->json([
                    "response" => $isDir
                ]);
            }


        } else {
            return response()->json([
                "response" => "There is no input file"
            ]);
        }
    }

    public function upload(Request $request)
    {
        if (Input::file()){
            $extension = $request->image->extension();
            $destinationPath = public_path().config('conf.dirs.albums');
            $name = rtrim(strtr(base64_encode($request->image->path()), '+/', '-_'), '=');
            $img = time().'_'.$name.".".$extension;
            $request->image->move($destinationPath, $img);

            return response()->json([
                "response" => config('conf.dirs.albums').$img
            ]);

        } else {
            return response()->json([
                "response" => "There is no input file"
            ]);
        }
    }

}