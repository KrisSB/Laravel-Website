<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\UserRole;

class GamesController extends Controller
{
    public function index()
    {
        $games = Game::orderBy('title','asc')->get();
        return view('games.index')->with('games',$games);
    }

    public function create()
    {
        return view('games.create');
    }

    public function store(Request $request)
    {
        //Make title required
        $this->validate($request,[
            'title' => 'required',
        ]);
        
        //store new table entry
        $game = new Game;
        $game->title = htmlspecialchars($request->input('title'));
        if(isset(auth()->user()->id)) {
            $game->user_id = auth()->user()->id;
        } else {
            $game->user_id = 0;
        }
        $game->visibility = 0;
        $game->IP_address = $this->getClientIP();
        $game->save();

        return redirect('/VideoGames')->with('success', 'Game Created');
    }

    public function show($id)
    {
        $game = Game::where('title', '=', $id)->first();
        if($game) {
            if($game->visibility == 0)
                $this->authorize('games.view', $game);
        } else {
            return redirect('/');
        }
        $privilege = 'showView';
        $wikis_data = $this->getWikiData($game,$privilege);
        return view('games.show')->with(compact('game','wikis_data'));
    }
    public function getWikiData($game,$privilege) {
        $permissions = $this->getPermissions($game->id,$privilege);
        $wikis = Game::find($game->id)->wiki;
        //Creating $wikis_data array to match the $wiki sections with the $wiki posts
        $wikis_data = array();

        foreach($wikis as $wiki) {
            if($wiki->visibility == 1 || $this->checkUser($wiki->user_id, $game->IP_address) || $permissions == true) {
                $wiki_posts = array();
                //Gets all the wiki_posts and pushes them into $wikis_data array together with the $wiki sections
                if($permissions == true) {
                    $wiki_posts = Game::find($game->id)->wiki_post->where('wiki_id', '=', $wiki->id)->all();
                } else {
                    $posts = Game::find($game->id)->wiki_post->where('wiki_id', '=', $wiki->id)->all();
                    foreach($posts as $post) {
                        if($post->visibility == 1 || $this->checkUser($post->user_id, $game->IP_address)) {
                            array_push($wiki_posts,$post);
                        }
                    }
                }
                $tempArray = array($wiki,$wiki_posts);
                array_push($wikis_data,$tempArray);
            }
        }
        return $wikis_data;
    }
    public function getPermissions($game_id,$privilege) {
        $user = $this->getUser();
        return Game::validateUser($user,$game_id,$privilege);
    }
    public function edit($id)
    {
        $game = Game::where('title', '=', $id)->first();
        return view('games.edit')->with('game',$game);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' => 'required',
        ]);
        
        $game = Game::where('title', '=', $id)->first();
        $game->title = $request->input('title');
        $game->save();

        return redirect('/VideoGames')->with('success', 'Game Updated');
    }

    public function updateVisibility($id) {
        $game = Game::where('title', '=', $id)->first();
        $game->visibility = 1;
        $game->save();

        return redirect('/VideoGames/' . $id)->with('success', 'Visibility Updated');
    }

    public function getDelete($id) {
        $game = Game::where('title', '=', $id)->first();
        return view('games.delete')->with('game',$game);
    }
    public function destroy($id)
    {
        $game = Game::where('title', '=', $id)->first();
        $game->delete();

        return redirect('/VideoGames')->with('success', 'Game Removed');
    }
}
