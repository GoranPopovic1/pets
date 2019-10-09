<?php $class = $thread->isUnread(Auth::id()) ? 'alert-info' : ''; ?>

<div class="alert {{ $class }}">
    <h4>
        <small><strong>{{ __('Naslov:') }}</strong> <a href="{{ route('messages.show', $thread->id) }}">{{ $thread->subject }}</a>
        ({{ $thread->userUnreadMessagesCount(Auth::id()) }} unread) </small>
    </h4>
    <p>
        <strong>{{ __('Poruka:') }}</strong> {{ $thread->latestMessage->body }}
    </p>
    <p>
        <strong>{{ __('Sagovornik:') }}</strong> {{ $thread->participantsString(Auth::id()) }}
    </p>

    <a href="#"
       onclick="event.preventDefault();
       document.getElementById('logout-form').submit();">
       {{ __('Obriši') }}
    </a>

    <form id="delete-message" action="{{ route('messages.destroy', $thread->id) }}" method="POST" style="display: none;">
        @method('DELETE')
        @csrf
    </form>
</div>
