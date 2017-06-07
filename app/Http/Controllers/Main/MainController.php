<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Place;
use App\Models\Event;
use Carbon\Carbon;

class MainController extends Controller
{
    public function index()
    {
        $events = Event::where('published', true)->get()->toArray();
        $posts = Post::where('published', true)->get()->toArray();
        $places = Place::where('published', true)->get()->toArray();

        foreach($events as $key => $event)
        {
            $dateFormatted =  Carbon::parse($event['date'])->format('d.m.Y');
            $events[$key]['date_formatted'] = $dateFormatted;
        }

        return view('pages.index', [
            'events' => $events,
            'posts' => $posts,
            'places' => $places
        ]);
    }


    public function rubricItem($rubric, $id)
    {
        return $rubric.$id;
    }

    /**
     *  todo:Загрузка галереи изображений
     */
    public function galleryUpload(Request $request)
    {
        $image_urls = [];

        foreach ($request->images as $file) {
            array_push($image_urls, $file);
        }

        return response()->json([
            "response" => $image_urls
        ]);
    }
}