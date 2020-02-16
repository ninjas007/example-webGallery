<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Like;
use App\Post;

class LikeController extends Controller
{
    public function postlike()
    {
    	$postId = input::get('postId');
    	$post = Post::find($postId);

    	if (!$post->YouLiked()) {
    		$post->youLikeIt();
    		return response()->json(['status' => 'success', 'message' => 'liked']);
    	} else {
    		// for unlike
    		$post->disLike();
    		return response()->json(['status' => 'success', 'message' => 'dislike']);
    	}
    }
}
