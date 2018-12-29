<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WikiPost extends Model
{
    //Set the tables to fillable so they can accessed through relationships
    protected $fillable = ['game_id','wiki_id','user_id','title','body','visibility','IP_address'];

    public function wiki() {
        return $this->belongsTo('App\Wiki');
    }
    public function game() {
        return $this->belongsTo('App\Game');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function revision_post() {
        return $this->hasMany('App\RevisionPost', 'post_id');
    }
}
