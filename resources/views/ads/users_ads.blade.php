@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if( count($usersAds) > 0 )
                    @foreach($usersAds as $usersAd)
                        <div class="card mb-2">
                            <div class="card-header"><a href="{{ url('ads/'. $usersAd->id) }}">{{ $usersAd->title }}</a></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        @foreach($usersAd->images as $image)
                                            <img src="{{ asset($image->image_path) }}" alt="ad-image" style="height: 100px;" />
                                            @break
                                        @endforeach
                                        <p class="card-text">{{ __('Opis:') }} {{ $usersAd->description }}</p>
                                        <p class="card-text">{{ __('Pol:') }} {{ $usersAd->sex->name }}</p>
                                        <p class="card-text">{{ __('Datum:') }} {{ $usersAd->created_at }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="card-text">{{ __('Mesto/Grad:') }} {{ $usersAd->user->city }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <b-alert show>Korisnik trenutno nema nijedan oglas.</b-alert>
                @endif
            </div>
        </div>
    </div>
@endsection