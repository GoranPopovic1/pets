@extends('layouts.app')

@section('content')
    <div class="container">
        {{--<div class="row justify-content-center">--}}
        {{--<div class="col-md-8">--}}
        {{--<div class="card-header">{{ __('Sortiranje') }}</div>--}}

        {{--<div class="card-body">--}}
        {{--<div class="row">--}}
        {{--<form method="GET" action="{{ url('search-results/sort') }}">--}}

        {{--<div class="form-group row">--}}

        {{--<select id="date"--}}
        {{--class="form-control @error('date') is-invalid @enderror"--}}
        {{--name="date" autocomplete="category" autofocus>--}}
        {{--<option value="">{{ __('Sortiraj po datumu') }}</option>--}}
        {{--<option value="muški">{{ __('ASC') }}</option>--}}
        {{--<option value="ženski">{{ __('DESC') }}</option>--}}
        {{--</select>--}}

        {{--@error('date')--}}
        {{--<span class="invalid-feedback" role="alert">--}}
        {{--<strong>{{ $message }}</strong>--}}
        {{--</span>--}}
        {{--@enderror--}}
        {{--</div>--}}

        {{--<div class="form-group row mb-0">--}}
        {{--<button type="submit" class="btn btn-primary">--}}
        {{--{{ __('Sortiraj') }}--}}
        {{--</button>--}}
        {{--</div>--}}

        {{--</form>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}

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
                        <form method="POST" action="{{ url('search-results') }}">
                            @csrf

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <b-form-checkbox id="category-1" v-model="status" name="category[]" value="psi" unchecked-value="not_accepted">{{ __('Psi') }}</b-form-checkbox>
                                    <b-form-checkbox id="category-2" v-model="status" name="category[]" value="macke" unchecked-value="not_accepted">{{ __('Mačke') }}</b-form-checkbox>
                                    <b-form-checkbox id="category-3" v-model="status" name="category[]" value="ptice" unchecked-value="not_accepted">{{ __('Ptice') }}</b-form-checkbox>
                                    <b-form-checkbox id="category-4" v-model="status" name="category[]" value="konji" unchecked-value="not_accepted">{{ __('Konji') }}</b-form-checkbox>
                                    <b-form-checkbox id="category-5" v-model="status" name="category[]" value="ribice" unchecked-value="not_accepted">{{ __('Ribice') }}</b-form-checkbox>
                                    <b-form-checkbox id="category-6" v-model="status" name="category[]" value="glodari" unchecked-value="not_accepted">{{ __('Glodari') }}</b-form-checkbox>
                                    <b-form-checkbox id="category-7" v-model="status" name="category[]" value="reptili" unchecked-value="not_accepted">{{ __('Reptili i amfibije') }}</b-form-checkbox>
                                    <b-form-checkbox id="category-8" v-model="status" name="category[]" value="ostalo" unchecked-value="not_accepted">{{ __('Ostalo') }}</b-form-checkbox>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sex" class="col-md-4 col-form-label text-md-right">{{ __('Pol') }}</label>

                                <select id="sex"
                                        class="form-control @error('sex') is-invalid @enderror"
                                        name="sex" autocomplete="category" autofocus>
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
                @if( count($ads) > 0 )
                    <sort ads="{{ $ads }}"></sort>
                @else
                    <b-alert show>Nema oglasa po zadatim kriterijumima.</b-alert>
                @endif
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
@endsection
