@extends('layouts.app')

    @section('content')
        {!! Form::open(['action' => ['WikisController@update', $game, $wiki->id], 'method' => 'POST',
                'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', $wiki->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
            </div>
            {{Form::hidden('_method','PUT')}}
            {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    @endsection