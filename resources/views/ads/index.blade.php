@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <form method="POST" action="{{ url('/search/form') }}">
                            @csrf

                            <div class="form-group d-inline-block align-middle">
                                <label for="category" class="col-form-label text-md-right">{{ __('Kategorija') }}</label>
                                <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" autocomplete="category" autofocus>
                                    <option value="">{{ __('Izaberi') }}</option>
                                    @foreach( $categories as $category )
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group d-inline-block align-middle">
                                <label for="sex" class="col-form-label text-md-right">{{ __('Pol') }}</label>
                                <select id="sex" class="form-control @error('sex') is-invalid @enderror" name="sex" autocomplete="sex" autofocus>
                                    <option value="">{{ __('Izaberi') }}</option>
                                    @foreach( $sexes as $sex )
                                        <option value="{{ $sex->id }}">{{ $sex->name }}</option>
                                    @endforeach
                                </select>
                                @error('sex')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group d-inline-block align-middle">
                                <label for="search-term" class="col-form-label text-md-right">{{ __('Ključne reči') }}</label>
                                <input id="search-term" type="text" placeholder="{{ __('Pretraži oglase') }}" class="form-control @error('search-term') is-invalid @enderror" name="search-term" autocomplete="search-term">
                                @error('search-term')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group d-inline-block align-bottom">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Pretraga') }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                @foreach($ads as $ad)
                    <div class="card mb-2">
                        <div class="card-header"><a href="{{ url('ads/'. $ad->id) }}">{{ $ad->title }}</a></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    @foreach($ad->images as $image)
                                        <img src="{{ asset($image->image_path) }}" alt="ad-image" style="height: 100px;" />
                                        @break
                                    @endforeach
                                    <p class="card-text">{{ __('Opis:') }} {{ $ad->description }}</p>
                                    <p class="card-text">{{ __('Pol:') }} {{ $ad->sex->name }}</p>
                                    <p class="card-text">{{ __('Datum:') }} {{ $ad->created_at }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="card-text">{{ __('Mesto/Grad:') }} {{ $ad->user->city }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{--@if( count($ads) > 0 )--}}
                {{--<ads-filter ads="{{ $ads }}"></ads-filter>--}}
            {{--@else--}}
                {{--<div class="alert alert-info">Trenutno nema oglasa.</div>--}}
            {{--@endif--}}
        </div>
    </div>
@endsection