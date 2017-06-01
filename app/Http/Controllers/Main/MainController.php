<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class MainController extends Controller
{
    public function rubricItem($rubric, $id)
    {
        return $rubric.$id;
    }
}