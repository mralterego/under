<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $social = Auth::user()->social;
        $social_items = json_decode($social);
        return view('admin.homepage', [
            'social' => $social,
            'site' => $social_items->site,
            'vk' => $social_items->vk,
            'fb' => $social_items->fb,
            'sc' => $social_items->sc,
        ]);
    }

    public function update(Request $request)
    {
        $id = Auth::user()->id;
        $social = $request->input('social');
        $out =  User::where('id', (int)($id))->update([
            'social' => $social
        ]);
        # если сохранение успешно output = true, иначе false
        return response()->json([
            "response" => $out
        ]);
    }
}
