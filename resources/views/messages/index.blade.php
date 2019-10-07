@extends('layouts.app')

@section('content')
    @include('messages.partials.flash')

    @each('messages.partials.thread', $threads, 'thread', 'messages.partials.no-threads')
@stop
