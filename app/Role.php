<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserRole;

class Role extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function user_role() {
        return $this->hasMany('App\UserRole');
    }
}
