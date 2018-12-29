<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wiki;

class WikisController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($game)
    {
        return redirect()->action('GamesController@show', ['game' => $game]);
    }
    public function create($game)
    {
        return view('wiki.create')->with('game',$game);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $game)
    {
        //Make title required
        $this->validate($request,[
            'title' => 'required',
        ]);
        
        $user_id = $this->getUser();
        //store new table entry
        $wiki = new Wiki;
        $wiki->game_id = $game;
        $wiki->title = htmlspecialchars($request->input('title'));
        $wiki->user_id = $user_id;
        $wiki->visibility = 0;
        $game_title =  $wiki->game->title;
        $wiki->IP_address = $this->getClientIP();
        $wiki->save();
        $this->storeRevision($wiki->id);
        if(!empty($request->input('body')) && !empty($request->input('subtitle'))) {
            $this->wikiPostStore($game,$wiki,$user_id,$request->input('subtitle'),
                                $request->input('body'));
        }

        return redirect('/VideoGames/' . $game_title)->with('success', 'Wiki Created');
    }
    private function storeRevision($wiki_id) {
        $wiki = Wiki::find($wiki_id);
        $wiki->revision_section()->create([
            'wiki_id' => $wiki->id,
            'user_id' => $wiki->user_id,
            'title' => $wiki->title,
            'checked' => 1,
            'IP_address' => $wiki->IP_address,
        ]);
    }
    /**
     * Stores the wikiPost into the wikiPost Table
     */
    private function wikiPostStore($game,$wiki,$user_id,$title,$body) {
        $test = $wiki->IP_address;
        $post = $wiki->wiki_post()->create([
            'game_id' => $game,
            'wiki_id' => $wiki->id,
            'user_id' => $user_id,
            'title' => htmlspecialchars($title),
            'body' => htmlspecialchars($body),
            'IP_address' => $wiki->IP_address,
        ]);
        $this->storePostRevision($wiki,$post->id);
    }
    private function storePostRevision($wiki,$post_id) {
        $wiki_post = $wiki->wiki_post()->find($post_id);
        $wiki_post->revision_post()->create([
            'post_id' => $wiki_post->id,
            'user_id' => $wiki_post->user_id,
            'title' => $wiki_post->title,
            'body' => $wiki_post->body,
            'checked' => 1,
            'IP_address' => $wiki_post->IP_address,
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($game_title,$id)
    {
        $user = $this->getUser();
        $wiki = Wiki::find($id);
        if($wiki) {
            if($wiki->visibility == 0 && $this->checkUser($wiki->user_id,$wiki->IP_address) == FALSE)
                $this->authorize('wikis.view', $wiki);
        } else {
            return redirect('/');
        }
        $privilege = 'showView';
        $wiki_posts = $this->getWikiPosts($wiki,$privilege);
        $revision_sections = $wiki->revision_section->where('checked', '=', 0)->all();
        return view('wiki.show')->with(compact('wiki','game_title','revision_sections','wiki_posts','user'));
    }
    public function getWikiPosts($wiki,$privilege) {
        $permissions = $this->getPermissions($wiki->id,$privilege);
        $wiki_posts = array();
        if($wiki->visibility == 1 || $this->checkUser($wiki->user_id, $wiki->IP_address) || $permissions == true) {
            //Gets all the wiki_posts and pushes them into $wikis_data array together with the $wiki sections
            if($permissions == true) {
                $wiki_posts = Wiki::find($wiki->id)->wiki_post->all();
            } else {
                $posts = Wiki::find($wiki->id)->wiki_post->all();
                foreach($posts as $post) {
                    if($post->visibility == 1 || $this->checkUser($post->user_id, $wiki->IP_address)) {
                        array_push($wiki_posts,$post);
                    }
                }
            }
        }
        return $wiki_posts;
    }
    public function getPermissions($wiki,$privilege) {
        $user = $this->getUser();
        return Wiki::validateUser($user,$wiki,$privilege);
    }
    public function updateVisibility($game_title,$id) {
        $wiki = Wiki::find($id);
        $wiki->visibility = 1;
        $wiki->save();

        return redirect('/VideoGames/' . $game_title . '/Wiki/' . $id)->with('success', 'Visibility Updated');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($game,$id)
    {
        $wiki = Wiki::find($id);
        return view('wiki.edit')->with('wiki', $wiki)->with('game',$game);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $game_title, $id)
    {
        $this->validate($request,[
            'title' => 'required',
        ]);
        $wiki = Wiki::find($id);
        $wiki->revision_section()->create([
            'wiki_id' => $wiki->id,
            'user_id' => $this->getUser(),
            'title' => $request->input('title'),
            'IP_address' => $this->getClientIP(),
        ]);

        return redirect('/VideoGames/' . $game_title . '/Wiki/' . $id)->with('success', 'Wiki Updated');
    }
    public function pushUpdate(Request $request, $game_title,$wiki_id,$id) {
        
        $wiki = Wiki::find($wiki_id);
        $revision_section = Wiki::find($wiki_id)->revision_section->find($id);
        if(isset($_POST['Yes'])) {
            $wiki->title = $revision_section->title;
            $wiki->visibility = 1;
            $wiki->IP_address = $revision_section->IP_address;
            $wiki->save();    
        } elseif(isset($_POST['No'])) {
            
        } else {
            return redirect('/VideoGames/' . $game_title . '/Wiki/' . $wiki->id)->with('error', 'Unauthorized Area');
        }
        $revision_section->checked = 1;
        $revision_section->save();
        return redirect('/VideoGames/' . $game_title . '/Wiki/' . $wiki->id)->with('success', 'Revision Updated');
    }
    public function getDelete($game_title,$id) {
        $wiki = Wiki::find($id);
        return view('wiki.delete')->with(compact('wiki','game_title'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($game_title, $id)
    {
        $wiki = Wiki::find($id);
        $wiki->delete();
        return redirect('/VideoGames/' . $game_title)->with('success', 'Wiki Removed');
    }

}
