<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function wiki() {
        return $this->hasMany('App\Wiki');
    }
    public function wiki_post() {
        return $this->hasMany('App\WikiPost');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function scopeValidateUser($id,$user_id,$wiki_id,$privileges) {
        return UserRole::validateUser($user_id,$wiki_id,$privileges);
    }
}
