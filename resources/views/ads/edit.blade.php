@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Izmeni oglas') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ url('ads/' . $adPost->id ) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Naslov') }}</label>
                                <div class="col-md-6">
                                    <input id="title" type="text" value="{{ $adPost->title }}" class="form-control @error('title') is-invalid @enderror" name="title" required autocomplete="title" autofocus>
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Opis') }}</label>
                                <div class="col-md-6">
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description" autofocus>{{ $adPost->description }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('Kategorija') }}</label>
                                <div class="col-md-6">
                                    <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" autocomplete="category" autofocus>
                                        <option value="">{{ __('Izaberi') }}</option>
                                        @foreach( $categories as $category )
                                            <option value="{{ $category->id }}" {{$adPost->category_id == $category->id  ? 'selected' : ''}}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sex" class="col-md-4 col-form-label text-md-right">{{ __('Pol') }}</label>
                                <div class="col-md-6">
                                    <select id="sex" class="form-control @error('sex') is-invalid @enderror" name="sex" autocomplete="sex" autofocus>
                                        <option value="">{{ __('Izaberi') }}</option>
                                        @foreach( $sexes as $sex )
                                            <option value="{{ $sex->id }}" {{$adPost->sex_id == $sex->id  ? 'selected' : ''}}>{{ $sex->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sex')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Slike') }}</label>
                                <div class="col-md-6">
                                    <input id="image" type="file" class="form-control-file @error('image') is-invalid @enderror" name="images[]" multiple>
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Sačuvaj izmene') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="card-body">
                        <div class="row mb-0">
                        @if(count($adPost->images) > 1)
                            @foreach($adPost->images as $image)
                                <div class="col-md-4">
                                    <img src="{{ asset($image->image_path) }}" alt="ad-image" style="height: 100px;" />
                                    <a href="{{ url('delete/ad/image/' . $image->id ) }}">Delete</a>
                                </div>
                            @endforeach
                        @else
                            @foreach($adPost->images as $image)
                                <div class="col-md-4">
                                    <img src="{{ asset($image->image_path) }}" alt="ad-image" style="height: 100px;" />
                                </div>
                            @endforeach
                        @endif
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ url('ads/' . $adPost->id ) }}">
                            @method('DELETE')
                            @csrf

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Obriši oglas') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
