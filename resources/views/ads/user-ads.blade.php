@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($userAds as $userAd)
                    <div class="card mb-2">
                        <div class="card-header"><a href="{{ url('ads/'. $userAd->id) }}">{{ __('Oglas') }}</a></div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="card-text">{{ __('Naslov:') }} {{ $userAd->title }}</p>
                                    @foreach($userAd->images as $image)
                                        <img src="{{ asset($image->image_path) }}" alt="ad-image" style="height: 100px;" />
                                        @break
                                    @endforeach
                                    <p class="card-text">{{ __('Opis:') }} {{ $userAd->description }}</p>
                                    <p class="card-text">{{ __('Pol:') }} {{ $userAd->sex }}</p>
                                    <p class="card-text">{{ __('Datum:') }} {{ $userAd->created_at }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="card-text">{{ __('Mesto/Grad:') }} {{ $userAd->user->city }}</p>
                                </div>
                            </div>
                            <div>
                                <b-button href="{{ url('ads/' . $userAd->id . '/edit') }}">{{ __('Izmeni oglas') }}</b-button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection