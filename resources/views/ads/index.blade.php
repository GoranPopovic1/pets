@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($ads as $ad)
                    <div class="card mb-2">
                        <div class="card-header"><a href="{{ url('ads/'. $ad->id) }}">Oglas</a></div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="card-text">Naslov: {{ $ad->title }}</p>
                                    @foreach($ad->images as $image)
                                        <img src="{{ asset($image->image_path) }}" alt="ad-image" style="height: 100px;" />
                                        @break
                                    @endforeach
                                    <p class="card-text">Opis: {{ $ad->description }}</p>
                                    <p class="card-text">Pol: {{ $ad->sex }}</p>
                                    <p class="card-text">Datum: {{ $ad->created_at }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="card-text">Mesto/Grad: {{ $ad->user->city }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection