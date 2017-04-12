@extends('master')

@section('pageTitle', 'News')

@section('content')
    @if ($topNews)
        <section class="top-news">
            <a href="{{ route('news.detail', ['id' => $topNews->id]) }}" class="feature-img"><img src="{{ $topNews->feature_url }}" alt=""></a>
            <a href="{{ route('news.detail', ['id' => $topNews->id]) }}" class="title"><h1>{{ $topNews->title }}</h1></a>
            <p class="excerpt">{{ $topNews->excerpt }}</p>
        </section>

        <section class="list-news">
            @foreach($listNews as $news)
                <article class="single-news row">
                    <div class="col-xs-4">
                        <a href="{{ route('news.detail', ['id' => $news->id]) }}" class="feature-img"><img src="{{ $news->thumb_url }}" alt=""></a>
                    </div>
                    <div class="col-xs-8">
                        <a href="{{ route('news.detail', ['id' => $news->id]) }}" class="title"><h2>{{ $news->title }}</h2></a>
                        <span>{{ date('d.m.Y', strtotime($news->created_at)) }}</span>
                    </div>
                </article>
            @endforeach
        </section>

        {!! $paginator->render() !!}
    @else
        <p>There is no news data</p>
    @endif
@endsection

