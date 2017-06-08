<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Place;
use App\Models\Event;
use App\Models\Collective;
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
    public function posts()
    {
        $posts= Post::where('published', true)->orderBy('created_at', 'DESK')->get()->toArray();

        return view('pages.posts', [
            "posts" => $posts
        ]);
    }



    public function rubricItem($rubric, $id)
    {
        $post = Post::where('rubric', $rubric)->where('id', $id)->where('published', true)->get()->toArray();

        return view('pages.post_item', [
            'post' => $post[0]
        ]);
    }


    public function events()
    {
        $today = Carbon::today();

        $events = Event::where('date', '>=', $today)->where('published', true)->get()->toArray();;

        foreach($events as $key => $event)
        {
            $dateFormatted =  Carbon::parse($event['date'])->format('d.m.Y');
            $events[$key]['date_formatted'] = $dateFormatted;
        }

        return view('pages.events', [
            "events" => $events
        ]);
    }

    public function eventItem($id)
    {
        $event = Event::where('id', $id)->where('published', true)->get()->toArray();

        return view('pages.event_item', [
            'event' => $event[0]
        ]);
    }


    public function places()
    {
        $places = Place::where('published', true)->get()->toArray();

        return view('pages.places', [
            "places" => $places
        ]);
    }

    public function placeItem($id)
    {
        $place = Place::where('id', $id)->get()->toArray();

        return view('pages.place_item', [
            'place' => $place[0]
        ]);
    }

    public function collectives()
    {
        $collectives = Collective::get()->toArray();

        return view('pages.collectives', [
            "collectives" => $collectives
        ]);
    }


    public function collectiveItem($id)
    {

        $collective = Collective::where('id', $id)->get()->toArray();

        return view('pages.collective_item', [
            'collective' => $collective[0]
        ]);
    }

}