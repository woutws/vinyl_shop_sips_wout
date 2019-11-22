@extends('layouts.template')

@section('shop_alt', 'shop_alt')

@section('main')


    @foreach($genres as $genre)
        <h2>{{ $genre->name }}</h2>
        <ul>
            @foreach($genre->records as $record)
                <li><a href="/shop/{{$record->id}}">{{$record->artist}} - {{$record->title}}</a> | price: € {{$record->price,2}} | Stock: {{$record->stock}}</li>
            @endforeach
        </ul>

    @endforeach

@endsection


