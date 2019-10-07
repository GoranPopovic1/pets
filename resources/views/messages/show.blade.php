@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <h1>{{ $thread->subject }}</h1>
        @each('messages.partials.messages', $thread->messages, 'message')

        @include('messages.partials.form-message')
    </div>
@stop
