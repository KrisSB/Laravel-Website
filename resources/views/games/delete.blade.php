@extends('layouts.app')

    @section('content')
        {!! Form::open(['action' => ['GamesController@destroy', $game->title],
                'method' => 'POST', 'class' => 'text-center']) !!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Yes',['class' => 'btn btn-danger'])}}
            <a href="{{URL::to('/')}}/VideoGames/{{$game->title}}">{{Form::button('No',['class' => 'btn btn-danger'])}}</a>
        {!! Form::close() !!}
    @endsection