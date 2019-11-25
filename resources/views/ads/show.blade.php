@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $ad->title }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                @foreach($ad->images as $image)
                                    <img src="{{ asset($image->image_path) }}" alt="ad-image" style="height: 100px;" />
                                @endforeach
                                <p class="card-text">{{ __('Opis:') }} {{ $ad->description }}</p>
                                <p class="card-text">{{ __('Pol:') }} {{ $ad->sex }}</p>
                                <p class="card-text">{{ __('Datum:') }} {{ $ad->created_at }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="card-text">{{ __('Ime:') }}
                                    @if( $adUser->id !== auth()->user()->id )
                                        <a href="{{ url('users/' . $adUser->id . '/ads') }}"> {{ $adUser->name }}</a>
                                    @else
                                        {{ $adUser->name }}
                                    @endif
                                </p>
                                <p class="card-text">{{ __('Telefon:') }} {{ $adUser->phone }}</p>
                                <p class="card-text">{{ __('Mesto/Grad:') }} {{ $adUser->city }}</p>

                                @if (Auth::guest())
                                    <a href="#" v-on:click.self.prevent v-b-tooltip.hover title="{{ __('Morate biti registrovani da biste poslali poruku.') }}">
                                        {{ __('Pošalji poruku') }}
                                    </a>
                                @else
                                    @if(auth()->user()->id !== $adUser->id)
                                        @if($thread == '')
                                            <a href="{{ route('messages.create', ['user_id' => $adUser->id]) }}">{{ __('Pošalji poruku') }}</a>
                                        @else
                                            <a href="{{ route('messages.show', ['message' => $thread->id]) }}">{{ __('Pošalji poruku') }}</a>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
