@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Postavi oglas</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('ads.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Naslov') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text"
                                           class="form-control @error('title') is-invalid @enderror" name="title"
                                           required autocomplete="title" autofocus>

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
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description" autofocus></textarea>

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
                                    <select id="category"
                                            class="form-control @error('category') is-invalid @enderror"
                                            name="category" required autocomplete="category" autofocus>
                                        <option value="">Izaberi</option>
                                        <option value="psi">Psi</option>
                                        <option value="mačke">Mačke</option>
                                        <option value="ptice">Ptice</option>
                                        <option value="konji">Konji</option>
                                        <option value="ribice">Ribice</option>
                                        <option value="glodari">Glodari</option>
                                        <option value="reptili">Reptili i amfibije</option>
                                        <option value="ostalo">Ostalo</option>
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
                                    <select id="sex"
                                            class="form-control @error('sex') is-invalid @enderror"
                                            name="sex" required autocomplete="category" autofocus>
                                        <option value="">Izaberi</option>
                                        <option value="muški">Muški</option>
                                        <option value="ženski">Ženski</option>
                                        <option value="oba">Oba Pola</option>
                                    </select>

                                    @error('sex')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Slike') }}</label>

                                <div class="col-md-6">
                                    <input id="image" type="file"
                                           class="form-control-file @error('image') is-invalid @enderror" name="image">

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
                                        {{ __('Sačuvaj promene') }}
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
