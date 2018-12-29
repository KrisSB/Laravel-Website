<?php

namespace App\Http\Controllers;

use Illuminate\Routing;

class PagesController {

    public function getHome() {
        $title = "Home";
        return view('index')->with('title',$title);
    }

    public function getHearthstone() {
        $title = "Hearthstone";
        return view('deckbuilder')->with('title',$title);
    }

    public function getRPGPlanners() {
        $title = "RPG Build Planners";
        return view('RPGPlanners')->with('title',$title);
    }
}