<?php $count = Auth::user()->newThreadsCount(); ?>
@if($count > 0)
    <span class="badge badge-danger">{{ $count }}</span>
@endif
