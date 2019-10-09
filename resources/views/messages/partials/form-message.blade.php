<h2>Napiši novu poruku</h2>
<form action="{{ route('messages.update', $thread->id) }}" method="post">
    @method('PUT')
    @csrf
        
    <!-- Message Form Input -->
    <div class="form-group">
        <textarea name="message" class="form-control">{{ old('message') }}</textarea>
    </div>

    <!-- Submit Form Input -->
    <div class="form-group">
        <button type="submit" class="btn btn-primary form-control">Pošalji</button>
    </div>
</form>