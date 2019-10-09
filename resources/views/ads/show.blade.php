@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Oglas</div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <p class="card-text">Naslov: {{ $ad->title }}</p>
                                @foreach($ad->images as $image)
                                    <img src="{{ asset($image->image_path) }}" alt="ad-image" style="height: 100px;" />
                                @endforeach
                                <p class="card-text">Opis: {{ $ad->description }}</p>
                                <p class="card-text">Pol: {{ $ad->sex }}</p>
                                <p class="card-text">Datum: {{ $ad->created_at }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="card-text">Ime: {{ $user->name }}</p>
                                <p class="card-text">Telefon: {{ $user->phone }}</p>
                                <p class="card-text">Mesto/Grad: {{ $user->city }}</p>

                                <a href="{{ route('messages.create', ['user_id' => $user->id]) }}">Pošalji poruku</a>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
