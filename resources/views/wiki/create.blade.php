@extends('layouts.app')

    @section('content')
        {!! Form::open(['action' => ['WikisController@store',$game], 'method' => 'POST',
                'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}

                {{Form::label('subtitle', 'Sub-Section Title')}}
                {{Form::text('subtitle', '', ['class' => 'form-control', 'placeholder' => 'Sub-Section Title'])}}

                {{Form::label('body', 'Body')}}
                {{Form::textarea('body', '', ['class' => 'form-control', 'placeholder' => 'Body Text'])}}
            </div>
            {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    @endsection