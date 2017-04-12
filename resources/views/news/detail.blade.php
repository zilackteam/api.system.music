@extends('master')

@section('pageTitle', 'News')

@section('content')
    @if ($news)
        <section class="news-detail">
            <img src="{{ $news->feature_img }}" class="img-responsive feature-img">
            <h1>{{$news->title}}</h1>
            <p class="excerpt">{{ $news->excerpt }}</p>
            <div class="news-content">
                {!! $news->content !!}
            </div>
        </section>

        <section class="list-news list-related">
            <h2>Tin liên quan</h2>
            @foreach($relatedNews as $related)
                <article class="single-news row">
                    <div class="col-xs-4">
                        <a href="{{ route('news.detail', ['id' => $related->id]) }}" class="feature-img"><img src="{{ $related->feature_url }}" alt=""></a>
                    </div>
                    <div class="col-xs-8">
                        <a href="{{ route('news.detail', ['id' => $related->id]) }}" class="title"><h2>{{ $related->title }}</h2></a>
                        <span>{{ date('d.m.Y', strtotime($related->created_at)) }}</span>
                    </div>
                </article>
            @endforeach
        </section>


    @else
        <p>There is no news data</p>
    @endif
@endsection