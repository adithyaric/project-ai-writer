@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Percakapan Saya</h1>
            <a href="{{ route('percakapan.create') }}" class="btn btn-primary">Buat Baru</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                @if ($percakapan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Layanan</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($percakapan as $chat)
                                    <tr>
                                        <td>{{ $chat->judul }}</td>
                                        <td>{{ $chat->layanan->nama }}</td>
                                        <td>{{ $chat->created_at->format('d M Y, H:i') }}</td>
                                        <td>
                                            <a href="{{ route('percakapan.show', $chat->id) }}"
                                                class="btn btn-sm btn-outline-primary">Lihat</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="mb-0">Belum ada percakapan. Silakan buat percakapan baru.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
