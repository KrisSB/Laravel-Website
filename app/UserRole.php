<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public function user() {
        $this->belongsTo('App\User');
    }
    public function role() {
        $this->belongsTo('App\Role');
    }
    public function wiki() {
        $this->belongsTo('App\Wiki');
    }
    public function scopeValidateUser($id,$user_id,$wiki_id,$privileges) {
        $user_role = $this::where([
            ['user_id', '=', $user_id],
            ['wiki_id', '=', NULL],
            ])->orWhere([
                ['user_id', '=', $user_id],
                ['wiki_id', '=', $wiki_id],
            ])->orderBy('role_id','asc')->first();
        if(!empty($user_role))
            return $this->getRole($privileges,$user_role);
        return false;
    }
    private function getRole($checkPrivileges,$user_role) {
        $role = Role::where('id', '=', $user_role->role_id)->first();
        $privileges = explode(":",$role->Privileges);   
        foreach($privileges as $privilege) {
            if($privilege == $checkPrivileges)
                return true;
        }
        return false;
    }
}
