@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Layanan</h1>
        <form action="{{ route('layanan.update', $layanan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="nama">Nama Layanan</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ $layanan->nama }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('layanan.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
