<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RevisionSection extends Model
{
    protected $fillable = ['wiki_id','user_id','title','checked','IP_address'];
    public function wiki() {
        $this->belongsTo('App\Wiki');
    }
}
