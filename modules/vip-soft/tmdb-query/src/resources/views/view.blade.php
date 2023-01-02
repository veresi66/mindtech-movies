@extends('core::layouts.main')

@section('title', 'TMDB listázó | Film adatlap')

@section('content')

    <div class="card">
        <div class="card-title h3 pt-1 ps-3">
            {{ $movie->title }}
        </div>
        <div class="card-body">
            <div class="row">
                <div>
                    Műfaj:
                    @foreach($genres as $genre)
                        @if ($loop->last)
                            {{ $genre->genre }}
                        @else
                            {{ $genre->genre }},
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-8">Hossza: {{ $movie->length_html }}</div>
                <div class="col-2">TMDB #: {{ $movie->tmdb_id }}</div>
            </div>
            <div class="row pt-3">
                <div>
                    {!! $movie->overview_html !!}
                </div>
            </div>
            <div class="row pt-3 text-start">
                <div class="col-6 ">
                    Borító:<br>
                    <img src="{{ $movie->poster_url }}" alt="Borítókép a TMDB oldalról">
                </div>
                <div class="col-6">
                    TMDB link:<br>
                    <a href="{{ $movie->tmdb_url }}" target="_blank">{{ $movie->tmdb_url }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-title h5 pt-1 ps-3">Rendező</div>
        <div class="card-body">
            <div class="row">
                <div class="col h5">{{ $director->name }}</div>
            </div>
            <div class="row">
                <div class="col-8">Születési ideje: {{ $director->birth_date_html }}</div>
                <div class="col-2">TMDB #: {{ $director->tmdb_id }}</div>
            </div>
            <div class="row pt-3">
                <div class="col">{!!  $director->biography_html !!}</div>
            </div>
        </div>
    </div>
@endsection
