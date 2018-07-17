<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $table = 'comments';

	// Relacción Many to one
    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }

	// Relacción Many to one
    public function video(){
    	return $this->belongsTo('App\Video', 'video_id');
    }
}
