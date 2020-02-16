<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    public function store(Request $request){

    	$request->validate([
    		'description' => 'required',
            'title' => 'required|max:30',
    		'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
    	]);

    	$post = New Post;
      $post->title = $request->title;
    	$post->description = $request->description;
    	$post->user_id = auth()->id();

    	if ($request->hasFile('image')) {
    		$file = $request->file('image');
    		$fileName = time().'.'.$file->getClientOriginalExtension();
    		$destinationPath = public_path('/images');
    		$file->move($destinationPath, $fileName);
    		$post->image = $fileName;
    	}

    	$post->save();
    	return back()->withMessage('Berhasil terkirim..');
    }

    public function index(){
      $posts = Post::orderBy('created_at', 'desc')->get();
        return view('post.index', ['posts' => $posts]);
    }
    
    public function postLikePost(Request $request)
    {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true';
        $update = false;
        $post = Post::find($post_id);
        if (!$post) {
          return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if ($like) {
            $already_like = $like->like;
            $update = true;
            if ($already_like == $is_like) {
                $like->delete();
                return null;
            }
        } else {
            $like = new Like();
        }
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if ($update) {
            $like->update();
        } else {
            $like->save();
        }
        return null;
    }

    public function destroy($id) 
    {
        // delete
        $data = Post::where('id', $id)->first();
        $data->delete();
        return back()->with('alert-success', 'Data berhasi dihapus!');
    }
}
