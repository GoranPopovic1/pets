@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($myAds as $myAd)
                    <div class="card mb-2">
                        <div class="card-header"><a href="{{ url('ads/'. $myAd->id) }}">{{ __('Oglas') }}</a></div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="card-text">{{ __('Naslov:') }} {{ $myAd->title }}</p>
                                    @foreach($myAd->images as $image)
                                        <img src="{{ asset($image->image_path) }}" alt="ad-image" style="height: 100px;" />
                                        @break
                                    @endforeach
                                    <p class="card-text">{{ __('Opis:') }} {{ $myAd->description }}</p>
                                    <p class="card-text">{{ __('Pol:') }} {{ $myAd->sex }}</p>
                                    <p class="card-text">{{ __('Datum:') }} {{ $myAd->created_at }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="card-text">{{ __('Mesto/Grad:') }} {{ $myAd->user->city }}</p>
                                </div>
                            </div>
                            <div>
                                <b-button href="{{ url('ads/' . $myAd->id . '/edit') }}">{{ __('Izmeni oglas') }}</b-button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection