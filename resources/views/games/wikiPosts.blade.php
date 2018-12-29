@if(!empty($wikis_data))
    <div class="wiki">
        @foreach($wikis_data as $wiki_data)
        <div class="wikiHeader">
            <a href="{{url()->current()}}/Wiki/{{$wiki_data[0]->id}}">{{$wiki_data[0]->title}}</a>
            @if($wiki_data[0]->visibility == 0)
                (Hidden)
            @endif
        </div>
        <section class="wikiContainer"> 
            @if(!empty($wiki_data[1]))
                @foreach($wiki_data[1] as $wiki_post)
                    <div class="wikiSection">
                        <div class="wikiSubHeader">
                            <a href="{{url()->current()}}/Wiki/{{$wiki_data[0]->id}}/Section/{{$wiki_post->id}}">{{$wiki_post->title}}</a>
                            @if($wiki_post->visibility == 0)
                                (Hidden)
                            @endif
                        </div>
                        <div class="wikiPost">
                            {!!$wiki_post->body!!}
                        </div>
                    </div>
                @endforeach
            @endif
        </section>
        @endforeach
    </div>
@endif