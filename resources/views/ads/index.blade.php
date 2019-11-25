@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <div class="card-header">{{ __('Filter') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <form method="POST" action="{{ url('search') }}">
                            @csrf

                            <div class="form-group row">
                                <div class="col-md-12">
                                    @php
                                        $categories = ['Psi', 'Mačke', 'Ptice', 'Konji', 'Ribice', 'Glodari', 'Reptili i amfibije', 'Ostalo'];
                                    @endphp
                                    @foreach( $categories as $cat )
                                        <input type="checkbox" id="category-1" name="category[]" value="{{ strtolower(str_replace(' ', '', $cat)) }}" /> {{ __($cat) }}<br/>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sex" class="col-md-4 col-form-label text-md-right">{{ __('Pol') }}</label>
                                <select id="sex" class="form-control @error('sex') is-invalid @enderror" name="sex" autocomplete="category" autofocus>
                                    <option value="">{{ __('Izaberi') }}</option>
                                    <option value="muški">{{ __('Muški') }}</option>
                                    <option value="ženski">{{ __('Ženski') }}</option>
                                    <option value="oba">{{ __('Oba Pola') }}</option>
                                </select>
                                @error('sex')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <input id="search" type="text" placeholder="{{ __('Pretraži oglase') }}" class="form-control @error('search') is-invalid @enderror" name="search" autocomplete="search">
                                @error('search')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group row mb-0">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Pretraga') }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
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
                                    <p class="card-text">{{ __('Pol:') }} {{ $ad->sex }}</p>
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

            <div class="col-md-2"></div>
        </div>
    </div>
@endsection