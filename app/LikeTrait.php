<?php 

namespace App;

trait LikeTrait
{
   
    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    // untuk store date ke dlam database
    public function youLikeIt()
    {
    	$like = New Like();
    	$like->user_id = auth()->user()->id;

    	$this->likes()->save($like);

    	return $like;
    }

    // method untuk ketika kita menyukai
    public function YouLiked()
    {
    	return !!$this->likes()->where('user_id', auth()->id())->count();
    }

    // function method untuk ketika kita dislike
    public function disLike()
    {
    	return $this->likes()->where('user_id', auth()->id())->delete();
    }

}