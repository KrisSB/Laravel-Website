@extends('layouts.app')

    @section('content')
        {{$wiki->title}}
        @foreach($revision_sections as $revision_section)
            @can('wikis.pushUpdate', $wiki)
                {{$revision_section->title}}
                {!! $revision_section->body !!}
                {!! Form::open(['action' => ['WikisController@pushUpdate', $game_title,$wiki,$revision_section],
                    'method' => 'POST', 'class' => 'text-center']) !!}
                    {{Form::submit('Yes',['class' => 'btn btn-danger', 'name' => 'Yes'])}}
                    {{Form::submit('No',['class' => 'btn btn-danger', 'name' => 'No'])}}
                {!! Form::close() !!}
            @endcan
        @endforeach
        @if($wiki->visibility === 0)
            {!! Form::open(['action' => ['WikisController@updateVisibility', $game_title, $wiki],
                'method' => 'POST', 'class' => 'float-right']) !!}
                {{Form::submit('Accept Wiki',['class' => 'btn btn-danger'])}}'
            {!! Form::close() !!}
        @endif
        <a href="{{url()->current()}}/edit">Edit</a>
        @can('wikis.delete', $wiki)
            {!! Form::open(['action' => ['WikisController@getDelete', $game_title, $wiki],
                    'method' => 'GET', 'class' => 'text-center']) !!}
                {{Form::submit('Delete',['class' => 'btn btn-danger'])}}'
            {!! Form::close() !!}
        @endcan
        <a href="/VideoGames/{{$wiki->game_id}}/Wiki/{{$wiki->id}}/Section/create">Create Sub-Section</a>
        @foreach($wiki_posts as $wiki_post)
            <a href="{{url()->current()}}/Section/{{$wiki_post->id}}">{{$wiki_post->title}}</a>
            @if($wiki_post->visibility == 0)
                (Hidden)
            @endif
            {{$wiki_post->body}}
        @endforeach
        <div id="root"></div>
    @endsection