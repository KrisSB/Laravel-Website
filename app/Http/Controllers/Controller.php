<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getUser() {
        $user_id = 0;
        if(isset(auth()->user()->id)) {
            $user_id = auth()->user()->id;
        } else {
            $user_id = 0;
        }
        return $user_id;
    }
    public function checkUser($user,$ip_address = NULL) {
        $current_user = $this->getUser();
        if($user == 0 && $ip_address == $this->getClientIP() && $current_user == 0) {
            return true;
        }   
        if($user == $this->getUser()) {
            return true;
        }
        return false;
    }
    public function getClientIP() {       
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            return  $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (array_key_exists('REMOTE_ADDR', $_SERVER)) {
            return $_SERVER["REMOTE_ADDR"]; 
        } elseif (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
            return $_SERVER["HTTP_CLIENT_IP"]; 
        } 
        return '';
   }
}
