<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $fillable = [
        'content',
    ];

    public function commentable()
    {
    	return $this->morphTo();
    }

    // karena membutuhkan relasi dari user maka kita juga buat relasi method
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
