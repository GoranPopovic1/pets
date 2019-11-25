<div class="media mb-5">
    {{-- Srediti putanju slike --}}
    <img class="mr-3 w-25" src="{{ asset($message->user->image) }}" alt="{{ $message->user->name }}">
    <div class="media-body">
        <h5 class="mt-0">{{ $message->user->name }}</h5>
        <p>{{ $message->body }}</p>
        <div class="text-muted">
            <small>Posted {{ $message->created_at->diffForHumans() }}</small>
        </div>
    </div>
</div>