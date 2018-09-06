<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;

class CommentController extends Controller
{
    public function postComment(Request $request, Post $post)
    {
    	$comment = new Comment;
    	$comment->content = $request->content;
    	$comment->user_id = auth()->user()->id;

    	// ini mengambil model dari tabel comment dan di save
    	$post->comments()->save($comment);

    	// return kembali dan beri session message
    	return back()->withMessage('Komentar terkirim');

    }
}
