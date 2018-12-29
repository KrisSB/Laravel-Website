@extends('layouts.app')
    @section('content')
        {{$wiki_post->title}}
        {!! $wiki_post->body !!}
        
            @foreach($revision_posts as $revision_post)
                @can('posts.update', [$revision_post, $wiki_post])
                    {{$revision_post->title}}
                    {!! $revision_post->body !!}
                @endcan
                @can('posts.pushUpdate', $wiki_post)
                    {!! Form::open(['action' => ['WikiPostsController@pushUpdate', $game_title,$wiki,$wiki_post->id,$revision_post->id],
                        'method' => 'POST', 'class' => 'text-center']) !!}
                        {{Form::submit('Yes',['class' => 'btn btn-danger', 'name' => 'Yes'])}}
                        {{Form::submit('No',['class' => 'btn btn-danger', 'name' => 'No'])}}
                    {!! Form::close() !!}
                @endcan
            @endforeach
        <a href="{{url()->current()}}/edit">Edit</a>
        @if($wiki_post->visibility === 0)
            {!! Form::open(['action' => ['WikiPostsController@updateVisibility', $game_title,$wiki,$wiki_post],
                'method' => 'POST', 'class' => 'float-right']) !!}
                {{Form::submit('Accept Post',['class' => 'btn btn-danger'])}}'
            {!! Form::close() !!}
        @endif
        @can('posts.delete', $wiki_post)
            {!! Form::open(['action' => ['WikiPostsController@getDelete', $game_title, $wiki,$wiki_post->id],
                    'method' => 'GET', 'class' => 'text-center']) !!}
                {{Form::submit('Delete',['class' => 'btn btn-danger'])}}'
            {!! Form::close() !!}
        @endcan
    @endsection