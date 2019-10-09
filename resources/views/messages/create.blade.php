@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nova poruka</h1>
        <form action="{{ route('messages.store') }}" method="post">
            @csrf
            <div class="col-md-6">
                <!-- Subject Form Input -->
                <div class="form-group">
                    <label class="control-label">Naslov</label>
                    <input type="text" class="form-control" name="subject"
                           value="{{ old('subject') }}">
                </div>

                <!-- Message Form Input -->
                <div class="form-group">
                    <label class="control-label">Poruka</label>
                    <textarea name="message" class="form-control">{{ old('message') }}</textarea>
                </div>

                @if(count($queryParams) > 0)
                    <input type="hidden" name="recipient"
                           value="{{ $queryParams['user_id'] }}">
                @endif

                <!-- Submit Form Input -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary form-control">Pošalji</button>
                </div>
            </div>
        </form>
    </div>
@endsection
