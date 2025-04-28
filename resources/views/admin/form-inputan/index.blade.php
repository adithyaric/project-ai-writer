@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Form Inputan for {{ $layanan->nama }}</h1>
        <a href="{{ route('form-inputan.create', $layanan) }}" class="btn btn-primary mb-3">Add Form Inputan</a>
        <textarea name="prompt_text" id="prompt_text" class="form-control">{{ $layanan->instruksiPrompt->prompt_text ?? '' }}</textarea>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Field</th>
                    <th>Tipe Field</th>
                    <th>Required</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($formInputans as $formInputan)
                    <tr>
                        <td>{{ $formInputan->nama_field }}</td>
                        <td>{{ $formInputan->tipe_field }}</td>
                        <td>{{ $formInputan->required ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('form-inputan.edit', $formInputan) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('form-inputan.destroy', $formInputan) }}" method="POST"
                                style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
