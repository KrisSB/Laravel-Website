<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RevisionPost extends Model
{
    protected $fillable = ['post_id','user_id','title','body','checked','IP_address'];

    public function wiki_post() {
        $this->belongsTo('App\WikiPost');
    }
}
