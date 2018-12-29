@extends('layouts.app')

    @section('content')
        <a href="VideoGames/create">Create Game</a>
        @foreach($games as $game)
            <a href="VideoGames/{{$game->title}}">{{$game->title}}</a>
        @endforeach
    @endsection