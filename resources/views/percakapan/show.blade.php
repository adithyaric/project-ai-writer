@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-xs-4 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Percakapan</h5>
                    </div>
                    <div class="card-body">
                        <h6>{{ $percakapan->judul }}</h6>
                        <p class="text-muted">{{ $percakapan->layanan->nama }}</p>

                        <h6 class="mt-4">Data Inputan:</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    @foreach ($percakapan->form_data as $key => $value)
                                        <tr>
                                            <td class="fw-bold">{{ $key }}</td>
                                            <td>{{ $value }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('percakapan.index') }}" class="btn btn-sm btn-outline-secondary">
                                &larr; Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-8 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Chat</h5>
                    </div>
                    <div class="card-body">
                        <div id="chat-container" class="mb-4" style="height: 400px; overflow-y: auto;">
                            @if ($percakapan->pertanyaan->count() > 0)
                                @foreach ($percakapan->pertanyaan as $pertanyaan)
                                    <div class="d-flex justify-content-end mb-3">
                                        <div class="card bg-primary text-white" style="max-width: 80%;">
                                            <div class="card-body py-2 px-3">
                                                <p class="mb-0">{{ $pertanyaan->isi_pertanyaan }}</p>
                                                <small
                                                    class="d-block text-end opacity-75">{{ $pertanyaan->created_at->format('H:i') }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($pertanyaan->jawaban)
                                        <div class="d-flex mb-3">
                                            <div class="card bg-light" style="max-width: 80%;">
                                                <div class="card-body py-2 px-3">
                                                    <p class="mb-0">{!! \Illuminate\Support\Str::markdown($pertanyaan->jawaban->isi_jawaban) !!}</p>
                                                    <small class="d-block text-end text-muted">{{ $pertanyaan->jawaban->created_at->format('H:i') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <p class="text-muted">Belum ada pesan. Mulai percakapan sekarang!</p>
                                </div>
                            @endif
                        </div>

                        <form id="chat-form">
                            @csrf
                            <div class="input-group">
                                <textarea id="isi_pertanyaan" name="isi_pertanyaan" class="form-control" placeholder="Ketik pesan..." rows="2"
                                    required></textarea>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Kirim
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatContainer = document.getElementById('chat-container');
            const chatForm = document.getElementById('chat-form');
            const messageInput = document.getElementById('isi_pertanyaan');

            // Scroll to bottom of chat
            function scrollToBottom() {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }

            // Initial scroll to bottom
            scrollToBottom();

            // Handle form submission
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const message = messageInput.value.trim();
                if (!message) return;

                // Disable form while processing
                const submitButton = chatForm.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                messageInput.disabled = true;

                // Add user message to chat
                const currentTime = new Date().toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                chatContainer.innerHTML += `
                <div class="d-flex justify-content-end mb-3">
                    <div class="card bg-primary text-white" style="max-width: 80%;">
                        <div class="card-body py-2 px-3">
                            <p class="mb-0">${message}</p>
                            <small class="d-block text-end opacity-75">${currentTime}</small>
                        </div>
                    </div>
                </div>

                <div id="loading-indicator" class="d-flex mb-3">
                    <div class="card bg-light" style="max-width: 80%;">
                        <div class="card-body py-2 px-3">
                            <div class="d-flex align-items-center">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                <span>AI sedang mengetik...</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;

                scrollToBottom();

                // Send to server
                fetch('/percakapan/' + {{ $percakapan->id }} + '/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            isi_pertanyaan: message
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Remove loading indicator
                        document.getElementById('loading-indicator').remove();

                        if (data.status === 'success') {
                            // Add AI response to chat
                            const responseTime = new Date(data.jawaban.created_at).toLocaleTimeString(
                            [], {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });

                            chatContainer.innerHTML += `
                        <div class="d-flex mb-3">
                            <div class="card bg-light" style="max-width: 80%;">
                                <div class="card-body py-2 px-3">
                                    <p class="mb-0">${data.jawaban.isi_jawaban}</p>
                                    <small class="d-block text-end text-muted">${responseTime}</small>
                                </div>
                            </div>
                        </div>
                    `;

                            scrollToBottom();
                            messageInput.value = '';
                        } else {
                            // Show error
                            chatContainer.innerHTML += `
                        <div class="d-flex mb-3">
                            <div class="card bg-danger text-white" style="max-width: 80%;">
                                <div class="card-body py-2 px-3">
                                    <p class="mb-0">Terjadi kesalahan: ${data.message}</p>
                                </div>
                            </div>
                        </div>
                    `;
                        }
                    })
                    .catch(error => {
                        // Remove loading indicator
                        document.getElementById('loading-indicator').remove();

                        // Show error
                        chatContainer.innerHTML += `
                    <div class="d-flex mb-3">
                        <div class="card bg-danger text-white" style="max-width: 80%;">
                            <div class="card-body py-2 px-3">
                                <p class="mb-0">Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.</p>
                            </div>
                        </div>
                    </div>
                `;
                    })
                    .finally(() => {
                        // Re-enable form
                        submitButton.disabled = false;
                        messageInput.disabled = false;
                        messageInput.focus();
                    });
            });
        });
    </script>
@endsection
@endsection
