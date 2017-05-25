<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\CMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
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
        $tags = implode(',', $post_params[0]['tags']);
        $published = $post_params[0]['published'];

        # убираем лишнее из контента, иначе сломается
        $content = str_replace("\n", "", $post_params[0]['content']);
        $content = str_replace("<p></p>", "", $content);
        $content = str_replace("<p>&nbsp;</p>", "", $content);

        # в колонке custom, которая должна быть BOOLEAN, по какой-то непонятной хранится также и NULL, поэтому делаем NULL в false
        if ($published == NULL) {
            $published = false;
        }

        # преобразуем true/false в 1/0
        $intPublished = (int)($published);

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
                'published' => $intPublished,
            ]
        );
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            "title" => "filled|required",
            "image" => "filled|required",
            "author" => "filled|required",
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
        $author = $request -> input('author');
        $gallery = $request -> input('gallery');
        $tags = json_encode(explode(",", $request->input('tags')));
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
        $id = $request -> input('id');
        $title = $request -> input('title');
        $image = $request -> input('image');
        $rubric = $request -> input('rubric');
        $author = $request -> input('author');
        $gallery = $request -> input('gallery');
        $tags = json_encode(explode(",", $request->input('tags')));
        $rating = [];

        $alias = trim(substr(CMS::rus2translit($title), 0, 100));

        $published = $request -> input('published') === '1' ? true : false;

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

}