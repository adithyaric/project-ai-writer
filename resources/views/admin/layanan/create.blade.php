@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Layanan</h1>
        <form action="{{ route('layanan.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="nama">Nama Layanan</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('layanan.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
