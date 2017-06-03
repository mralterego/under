<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rubric;

class RubricController extends Controller
{
    public function index()
    {
        return view('admin.rubrics');
    }

    public function api(Request $request)
    {
        $rubrics = Rubric::get();

        return response()->json([
            'response' => $rubrics
        ]);

    }

    public function create(Request $request)
    {
        $this->validate($request, [
            "name" => "filled|required",
            "alias" => "filled|required",
        ]);

        if (Auth::user()->role == 5){

            $name = trim(strip_tags($request -> input('name')));
            $alias = mb_strtolower(strip_tags($request -> input('alias')));

            $item = [
                'name' => $name,
                'alias' => $alias
            ];

            $out = Rubric::create($item);

            return response()->json([
                "response" => $out
            ]);

        } else {

            return response()->json([
                'response' => "Доступ запрещен!"
            ]);
        }

    }

    public function remove(Request $request)
    {
        $this->validate($request, [
            "id" => "filled|required",
        ]);

        if (Auth::user()->role == 5){
            $id = $request->input('id');
            $id = (int)($id);

            $removed = Rubric::where('id', $id)->delete();

            return response()->json([
                'response' => $removed
            ]);

        } else {

            return response()->json([
                'response' => "Доступ запрещен!"
            ]);
        }

    }

}