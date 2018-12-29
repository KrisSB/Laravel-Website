@extends('layouts.app')

    @section('content')
    {!! Form::open(['action' => ['WikiPostsController@destroy', $game_title, $wiki,$wiki_post->id],
                'method' => 'POST', 'class' => 'text-center']) !!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Yes',['class' => 'btn btn-danger'])}}
            <a href="{{URL::to('/')}}/VideoGames/{{$game_title}}">{{Form::button('No',['class' => 'btn btn-danger'])}}</a>
        {!! Form::close() !!}
    @endsection