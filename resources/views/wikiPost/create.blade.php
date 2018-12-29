@extends('layouts.app')

    @section('content')
        {!! Form::open(['action' => ['WikiPostsController@store',$game,$wiki], 'method' => 'POST',
                'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}

                {{Form::label('body', 'Body')}}
                {{Form::textarea('body', '', [ 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
            </div>
            {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    @endsection