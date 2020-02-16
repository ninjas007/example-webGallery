<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;

class FrontpageController extends Controller
{
   	public function index()
    {
        $posts = Post::all();
        return view('front', compact('posts'));
    }
}
