@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Layanan</h1>
        <a href="{{ route('layanan.create') }}" class="btn btn-primary mb-3">Add Layanan</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Instruksi Prompt</th>
                    <th>Form Inputan</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($layanans as $layanan)
                    <tr>
                        <td>{{ $layanan->nama }}</td>
                        <td>
                            @if ($layanan->instruksiPrompt)
                                <a href="{{ route('instruksi-prompt.edit', $layanan) }}" class="btn btn-sm btn-info">Edit Prompt</a>
                            @else
                                <a href="{{ route('instruksi-prompt.edit', $layanan) }}" class="btn btn-sm btn-success">Add Prompt</a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('form-inputan.index', $layanan) }}" class="btn btn-sm btn-primary">Manage Forms</a>
                        </td>
                        <td>
                            <a href="{{ route('layanan.edit', $layanan) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('layanan.destroy', $layanan) }}" method="POST" style="display:inline">
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
