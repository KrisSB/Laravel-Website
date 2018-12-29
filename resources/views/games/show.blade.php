@extends('layouts.app')

    @section('content')
        <header class="header">{{$game->title}}</header> 
        <a href="{{$game->id}}/Wiki/create">Add Section</a>
        @if(!Auth::guest())
            <a href="{{$game->title}}/edit">Edit</a>
            @if($game->visibility === 0)
                {!! Form::open(['action' => ['GamesController@updateVisibility', $game->title],
                    'method' => 'POST', 'class' => 'float-right']) !!}
                    {{Form::submit('Accept Game',['class' => 'btn btn-danger'])}}'
                {!! Form::close() !!}
            @endif
            @can('games.delete', $game)
                {!! Form::open(['action' => ['GamesController@getDelete', $game->title],
                    'method' => 'GET', 'class' => 'float-right']) !!}
                    {{Form::submit('Delete',['class' => 'btn btn-danger'])}}'
                {!! Form::close() !!}
            @endcan
        @endif
        @include('games.wikiPosts',['wikis_data' => $wikis_data])
    @endsection