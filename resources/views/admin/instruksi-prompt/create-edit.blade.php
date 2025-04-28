@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Instruksi Prompt for {{ $layanan->nama }}</h1>
        <form action="{{ route('instruksi-prompt.update', $layanan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="prompt_text">Prompt Text</label>
                <textarea name="prompt_text" id="prompt_text" class="form-control" rows="10" required>{{ $instruksiPrompt->prompt_text ?? '' }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
