@extends('core::layouts.main')

@section('title', 'TMDB listázó')

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="col-1">#</th>
                <th class="col-5">Cím</th>
                <th class="col-3">Átlag</th>
                <th class="col-3">Szavazatok száma</th>
            </tr>
        </thead>
        <tbody>
        @foreach($movies as $movie)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td><a href="{{ route('page.view', $movie->id) }}" class="w100">{{ $movie->title }}</td>
                <td>{{ $movie->tmdb_average }}</td>
                <td>{{ $movie->tmdb_count }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
