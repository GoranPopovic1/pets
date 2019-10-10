@extends('layouts.app')

@section('content')
    <div class="container">
        @include('messages.partials.flash')

        @each('messages.partials.thread', $threads, 'thread', 'messages.partials.no-threads')
    </div>
@endsection
