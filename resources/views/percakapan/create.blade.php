@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Buat Percakapan Baru</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('percakapan.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Percakapan</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    id="judul" name="judul" value="{{ old('judul') }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="layanan_id" class="form-label">Pilih Layanan</label>
                                <select id="layanan_id" name="layanan_id"
                                    class="form-select @error('layanan_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Layanan --</option>
                                    @foreach ($layanan as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('layanan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="dynamic-form-container" class="mb-3">
                                <!-- Dynamic form inputs will be loaded here -->
                                <div class="text-center py-3 dynamic-form-placeholder">
                                    <p class="text-muted">Silakan pilih layanan terlebih dahulu</p>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Buat Percakapan</button>
                                <a href="{{ route('percakapan.index') }}" class="btn btn-outline-secondary">Batal</a>
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
            const layananSelect = document.getElementById('layanan_id');

            layananSelect.addEventListener('change', function() {
                const layananId = this.value;
                const formContainer = document.getElementById('dynamic-form-container');

                if (!layananId) {
                    formContainer.innerHTML = `
                    <div class="text-center py-3 dynamic-form-placeholder">
                        <p class="text-muted">Silakan pilih layanan terlebih dahulu</p>
                    </div>
                `;
                    return;
                }

                // Show loading indicator
                formContainer.innerHTML = `
                <div class="text-center py-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat form...</p>
                </div>
            `;

                // Fetch form inputs for selected layanan
                fetch(`/percakapan/form-inputan/${layananId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            formContainer.innerHTML = `
                            <div class="alert alert-info">
                                Tidak ada inputan untuk layanan ini
                            </div>
                        `;
                            return;
                        }

                        let formHtml =
                            '<div class="border rounded p-3 mb-3"><h6 class="mb-3">Isi Data Layanan</h6>';

                        data.forEach(input => {
                            const fieldId = `form_${input.id}`;
                            const isRequired = input.required ? 'required' : '';

                            formHtml += `
                            <div class="mb-3">
                                <label for="${fieldId}" class="form-label">${input.nama_field} ${input.required ? '<span class="text-danger">*</span>' : ''}</label>
                        `;

                            // Render different input types based on tipe_field
                            switch (input.tipe_field) {
                                case 'text':
                                case 'string':
                                    formHtml +=
                                        `<input type="text" class="form-control" id="${fieldId}" name="${fieldId}" ${isRequired}>`;
                                    break;
                                case 'number':
                                case 'integer':
                                    formHtml +=
                                        `<input type="number" class="form-control" id="${fieldId}" name="${fieldId}" ${isRequired}>`;
                                    break;
                                case 'float':
                                case 'numeric':
                                    formHtml +=
                                        `<input type="number" step="0.01" class="form-control" id="${fieldId}" name="${fieldId}" ${isRequired}>`;
                                    break;
                                case 'date':
                                    formHtml +=
                                        `<input type="date" class="form-control" id="${fieldId}" name="${fieldId}" ${isRequired}>`;
                                    break;
                                case 'textarea':
                                    formHtml +=
                                        `<textarea class="form-control" id="${fieldId}" name="${fieldId}" rows="3" ${isRequired}></textarea>`;
                                    break;
                                default:
                                    formHtml +=
                                        `<input type="text" class="form-control" id="${fieldId}" name="${fieldId}" ${isRequired}>`;
                            }

                            formHtml += `</div>`;
                        });

                        formHtml += '</div>';
                        formContainer.innerHTML = formHtml;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        formContainer.innerHTML = `
                        <div class="alert alert-danger">
                            Terjadi kesalahan saat memuat form. Silakan coba lagi.
                        </div>
                    `;
                    });
            });
        });
    </script>
@endsection
@endsection
