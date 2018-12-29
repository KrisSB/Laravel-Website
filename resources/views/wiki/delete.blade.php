@extends('layouts.app')

    @section('content')
        {!! Form::open(['action' => ['WikisController@destroy', $game_title, $wiki],
                'method' => 'POST', 'class' => 'text-center']) !!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Yes',['class' => 'btn btn-danger'])}}
            <a href="{{URL::to('/')}}/VideoGames/{{$game_title}}/Wiki/{{$wiki}}">{{Form::button('No',['class' => 'btn btn-danger'])}}</a>
        {!! Form::close() !!}
    @endsection