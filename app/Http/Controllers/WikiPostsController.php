<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WikiPost;

class WikiPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Sends user to wikiPost.create view
     */
    public function create($game,$wiki)
    {
        return view('wikiPost.create')->with(compact('game','wiki'));
    }

    /**
     * Validates title and body have input
     * Stores into the WikiPost table
     * Calls storeRevision method to create a revision for the Post 
     */
    public function store(Request $request, $game, $wiki)
    {
        $this->validate($request,[
            'title' => 'required',
            'body' => 'required',
        ]);
        $wiki_post = new WikiPost;
        $wiki_post->game_id = $game;
        $wiki_post->wiki_id = $wiki;
        $wiki_post->user_id = $this->getUser();
        $wiki_post->body = $request->input('body');
        $wiki_post->visibility = 0;
        $wiki_post->title = $request->input('title');
        $wiki_post->IP_address = $this->getClientIP();
        $wiki_post->save();
        
        $this->storeRevision($wiki_post->id);
        $game_title =  $wiki_post->game->title;
        return redirect('/VideoGames/' . $game_title)->with('success','Wiki Created');
    }
    public function storeRevision($post_id) {
        $wiki_post = WikiPost::find($post_id);
        $wiki_post->revision_post()->create([
            'post_id' => $wiki_post->id,
            'user_id' => $wiki_post->user_id,
            'title' => $wiki_post->title,
            'body' => $wiki_post->body,
            'checked' => 1,
            'IP_address' => $this->getClientIP(),
        ]);
    }

    /**
     * Calls getWikiPost method which returns false or returns an entry from the wiki_posts Table
     * if false redirect to homepage
     * Otherwise shows page the show page
     */
    public function show($game_title,$wiki,$id)
    {
        $wiki_post = $this->getWikiPost($game_title,$wiki,$id);
        if($wiki_post->visibility == 0 && $this->checkUser($wiki_post->user_id,$wiki_post->IP_address) == FALSE)
            $this->authorize('posts.view', $wiki_post);

        if($wiki_post === false) 
            return redirect('/');

        $revision_posts = $wiki_post->revision_post->where('checked', '=', 0)->all();
        return view('wikiPost.show')->with(compact('game_title','wiki','wiki_post','revision_posts'));
    }
    public function updateVisibility($game_title,$wiki,$id) {
        $wiki_post = WikiPost::find($id);
        $wiki_post->visibility = 1;
        $wiki_post->save();

        return redirect('/VideoGames/' . $game_title . '/Wiki/' . $wiki . '/Section/' . $id)->with('success', 'Visibility Updated');
    }
    /**
     * calls getWikiPost method
     * checks to see if the user has already made a revision that hasn't been checked yet.
     * if so the user will edit that revision instead of the current update
     */
    public function edit($game_title,$wiki,$id)
    {
        $wiki_post = $this->getWikiPost($game_title,$wiki,$id);

        if($wiki_post === false) 
            return redirect('/');

        $user_id = $this->getUser();
        $revision_post = $wiki_post->revision_post()->where([
            ['checked', '=', '0'],
            ['user_id', '=', $user_id],
        ])->first();
        if(!empty($revision_post)) {
            $post_title = $revision_post->title;
            $post_body  = $revision_post->body;
        } else {
            $post_title = $wiki_post->title;
            $post_body  = $wiki_post->body;
        }
        return view('wikiPost.edit')->with(compact('game_title','wiki','wiki_post','post_title','post_body'));
    }

    /**
     * Checks to see if the user has made a revision already
     * if !empty it will update that revision post
     * if empty it will create a revision for the user
     */
    public function update(Request $request, $game_title, $wiki, $id)
    {
        $this->validate($request,[
            'title' => 'required',
            'body' => 'required',
        ]);
        
        $wiki_post = $this->getWikiPost($game_title,$wiki,$id);
        if($wiki_post === false) 
            return redirect('/');

        $user_id = $this->getUser();
        $revision_post = $wiki_post->revision_post()->where([
            ['checked', '=', '0'],
            ['user_id', '=', $user_id],
        ])->first();
        if(!empty($revision_post)) {
            $revision_post->update([
                'post_id' => $wiki_post->id,
                'user_id' => $this->getUser(),
                'title' => htmlspecialchars($request->input('title')),
                'body' => htmlspecialchars($request->input('body')),
            ]);
        } else {
            $wiki_post->revision_post()->create([
                'post_id' => $wiki_post->id,
                'user_id' => $this->getUser(),
                'title' => htmlspecialchars($request->input('title')),
                'body' => htmlspecialchars($request->input('body')),
                'IP_address' => $this->getClientIP(),
            ]);
        }

        return redirect('/VideoGames/' . $game_title . '/Wiki/' . $wiki . '/Section/' . $id)->with('success', 'Revision Created');
    }
    /**
     * Pushes Revision Update to be the current update
     */
    public function pushUpdate(Request $request, $game_title,$wiki,$post_id,$id) {
        
        $wiki_post = WikiPost::find($post_id);
        $revision_post = $wiki_post->revision_post->find($id);
        if(isset($_POST['Yes'])) {
            $wiki_post->title = $revision_post->title;
            $wiki_post->body = $revision_post->body;
            $wiki_post->visibility = 1;
            $wiki_post->IP_address = $revision_post->IP_address;
            $wiki_post->save();    
        } elseif(isset($_POST['No'])) {

        } else {
            return redirect('/VideoGames/' . $game_title . '/Wiki/' . $wiki . '/Section/' . $post_id)->with('error', 'Unauthorized Area');
        }
        $revision_post->checked = 1;
        $revision_post->save();
        return redirect('/VideoGames/' . $game_title . '/Wiki/' . $wiki . '/Section/' . $post_id)->with('success', 'Section Updated');
    }
    /**
     * Sends user to the delete page to prompt them to use the destroy method
     */
    public function getDelete($game_title,$wiki,$id) {
        $wiki_post = $this->getWikiPost($game_title,$wiki,$id);
        if($wiki_post === false) 
            return redirect('/');
        return view('wikiPost.delete')->with(compact('game_title','wiki','wiki_post'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($game_title,$wiki,$id)
    {
        $wiki_post = WikiPost::find($id);
        $this->authorize('posts.delete', $wiki_post);
        $wiki_post->delete();

        return redirect('/VideoGames/' . $game_title . '/Wiki/' . $wiki)->with('success', 'Section Removed');
    }
    /**
     * Method looks in WikiPost table to find post that matches the criteria, else false
     */
    public function getWikiPost($game_title,$wiki,$id) {

        $wiki_check = WikiPost::find($id);
        if(empty($wiki_check)) 
            return false;

        $game = $wiki_check->game;
        if($game->title != $game_title) 
            return false;

        $wiki_post = WikiPost::where([
            ['id', '=', $id],
            ['game_id', '=', $game->id],
            ['wiki_id', '=', $wiki]
        ])->first();
        if(empty($wiki_post))
            return false;
        return $wiki_post;
    }
}
