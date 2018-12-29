<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wiki extends Model
{
    protected $fillable = ['wiki_id','user_id','title','visibility','IP_address'];

    public function game() {
        return $this->belongsTo('App\Game');
    }
    public function wiki_post() {
        return $this->hasMany('App\WikiPost');
    }
    public function revision_section() {
        return $this->hasMany('App\RevisionSection');
    }
    public function user_role() {
        return $this->hasMany('App\UserRole');
    }
    public function scopeValidateUser($id,$user_id,$wiki_id,$privileges) {
        return UserRole::validateUser($user_id,$wiki_id,$privileges);
    }
}
