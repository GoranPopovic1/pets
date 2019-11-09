@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Moj nalog</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="card-text">Ime: {{ $name }}</p>
                                <p class="card-text">E-Mail: {{ $email }}</p>
                                <p class="card-text">Grad: {{ $city }}</p>
                                <p class="card-text">Telefon: {{ $phone }}</p>
                                <b-button href="{{ url('users/' . auth()->user()->id . '/edit') }}">{{ __('Izmeni nalog') }}</b-button>
                                <form method="POST" action="{{ url('users/' . auth()->user()->id ) }}">
                                    @method('DELETE')
                                    @csrf

                                    <div class="form-group row">
                                        <label for="password-delete" class="col-md-4 col-form-label text-md-right">{{ __('Lozinka') }}</label>
                                        <div class="col-md-6">
                                            <input id="password-delete" type="password" class="form-control @error('password-delete') is-invalid @enderror" name="password-delete" autocomplete="new-password">
                                            @error('password-delete')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Izbriši nalog') }}
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="col-md-6">
                                @if( $image )
                                    <img src="{{ $image }}" alt="user-image" class="img-thumbnail" />
                                @else
                                    <img src="{{ asset('images/user/default-avatar.jpg') }}" alt="user-image" class="img-thumbnail" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
