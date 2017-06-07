<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\CMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Carbon\Carbon;


class PostsController extends Controller
{

    public function index()
    {
        return view('admin.post');
    }

    public function postsList()
    {
        return view('admin.posts_list');
    }

    public function item($id)
    {
        $id = Post::where('id', (int)($id)) -> value('id');

        # если нет id -> 404
        if ($id == false){
            abort(404);
        }

        # забираем массив параметров событий
        $post_params = Post::where('id', $id) -> get();

        $title =  $post_params[0]['title'];
        $image = $post_params[0]['image'];
        $gallery = $post_params[0]['gallery'];
        $rubric = $post_params[0]['rubric'];
        $tags = $post_params[0]['tags'];
        $published = $post_params[0]['published'];

        # убираем лишнее из контента, иначе сломается
        $content = str_replace("\n", "", $post_params[0]['content']);
        $content = str_replace("<p></p>", "", $content);
        $content = str_replace("<p>&nbsp;</p>", "", $content);

        # в колонке custom, которая должна быть BOOLEAN, по какой-то непонятной хранится также и NULL, поэтому делаем NULL в false
        if ($published == NULL) {
            $published = false;
        }
        if (is_array($tags)){
            $tags = json_encode($tags);
        }

        # выводим
        return view('admin.posts_item',
            [
                'id' => $id,
                'title' => $title,
                'gallery' => $gallery,
                'rubric' => $rubric,
                'content' => $content,
                'image' => $image,
                'tags' => $tags,
                'published' => $published,
            ]
        );
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            "title" => "filled|required",
            "image" => "filled|required",
            "rubric" => "filled|required",
            "gallery" => "filled|required",
            "content" => "filled",
            "tags" => "filled",
            "published" => "filled",
        ]);

        # входные параметры для создания события
        $title = $request -> input('title');
        $image = $request -> input('image');
        $rubric = $request -> input('rubric');
        $content = $request -> input('content');
        $author = Auth::user()->name;
        $gallery = $request -> input('gallery');
        $tags = $request -> input('tags');
        $published = $request -> input('published') === "true" ? true : false;
        $rating = [];

        $content = str_replace("<p></p>", "", $content);
        $content = str_replace("<p>&nbsp;</p>", "", $content);
        $alias = trim(substr(CMS::rus2translit($title), 0, 100));

        # сохраняем новую новость в бд
        $item =
            [
                'title' => $title,
                'content' => $content,
                'alias' =>  str_replace(' ', '_', $alias),
                'rubric' => $rubric,
                'author' => $author,
                'gallery' => $gallery,
                'image' => $image,
                'tags' => $tags,
                'rating' => json_encode($rating),
                'published' => $published,
            ];

        $out = Post::create($item);

        # если сохранение успешно output = true, иначе false
        return response()->json([
            "response" => $out
        ]);
    }

    public function update(Request $request)
    {
        /**
        $this->validate($request, [
        'id' => 'required|filled',
        'title' => 'required|filled',
        'date' => 'required|filled',
        'link' => 'required|filled',
        'image' => 'required|filled',
        'place' => 'required|filled',
        'price' => 'required|filled',
        'tags' => 'required|filled',
        'content' => 'filled',
        'published' => 'filled'
        ]);
         **/

        # входные параметры для создания события
        $author = Auth::user()->name;
        $id = $request -> input('id');
        $title = $request -> input('title');
        $image = $request -> input('image');
        $rubric = $request -> input('rubric');
        $gallery = $request -> input('gallery');
        $tags = $request->input('tags');
        $rating = [];

        $alias = trim(substr(CMS::rus2translit($title), 0, 100));

        $published = $request -> input('published') === 'true' ? true : false;

        $content = $request -> input('content');
        $content = str_replace("\n", "", $content);
        $content = str_replace("<br>", "", $content);
        $content = str_replace("<p></p>", "", $content);

        $out =  Post::where('id', (int)($id))->update(
            [
                'title' => $title,
                'author' => $author,
                'alias' => $alias,
                'rubric' => $rubric,
                'gallery' => $gallery,
                'content' => $content,
                'image' => $image,
                'tags' => $tags,
                'rating' => json_encode($rating),
                'published' => $published,
            ]
        );

        # если сохранение успешно output = true, иначе false
        return response()->json([
            "response" => $out
        ]);
    }

    public function getRate(Request $request)
    {
        $id = $request -> input('postId');
        $rating = Post::where('id', (int)($id))->pluck('rating');
        $actualRate = 0;

        if (!empty($rating[0])){
            foreach($rating[0] as $key => $r){
                $actualRate = $actualRate + (int)($r['rate']);
            }
            $actualRate = $actualRate / count($rating[0]);
        }
        return response()->json([
            "response" => $actualRate
        ]);
    }

    public function api()
    {
        $posts = Post::get();
        /**
        if (!empty($places)){
        foreach ($places as $place){
        $place['tags'] = json_encode($place['tags']);
        }
        }
         **/
        return response()->json([
            'response' => $posts
        ]);
    }

    public function upload(Request $request)
    {
        if (Input::file()){
            $extension = $request->image->extension();
            $destinationPath = public_path().config('conf.dirs.posts');
            $name = rtrim(strtr(base64_encode($request->image->path()), '+/', '-_'), '=');
            $img = time().'_'.$name.".".$extension;
            $request->image->move($destinationPath, $img);

            return response()->json([
                "response" => config('conf.dirs.posts').$img
            ]);

        } else {
            return response()->json([
                "response" => "There is no input file"
            ]);
        }
    }


    public function galleryUpload($id, Request $request)
    {
        $out = "";

        $files = Input::file();
        $arr_urls = [];

        // foreach ($files as $file){
        //$ext = $file->getClientOriginalExtension();
        //  $name = $file->getClientOriginalName();
        //}

        return response()->json([
            "response" => $id
        ]);
    }

}