@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($formInputan) ? 'Edit' : 'Create' }} Form Inputan</h1>
    <form
        action="{{ isset($formInputan) ? route('form-inputan.update', $formInputan) : route('form-inputan.store', $layanan) }}"
        method="POST">
        @csrf
        @if(isset($formInputan)) @method('PUT') @endif
        <div class="form-group">
            <label for="nama_field">Nama Field</label>
            <input type="text" name="nama_field" id="nama_field" class="form-control"
                value="{{ $formInputan->nama_field ?? '' }}" required>
        </div>
        <div class="form-group">
            <label for="tipe_field">Tipe Field</label>
            <select name="tipe_field" id="tipe_field" class="form-control" required>
                <option value="string" {{ (isset($formInputan) && $formInputan->tipe_field === 'string') ? 'selected' : '' }}>String</option>
                <option value="textarea" {{ (isset($formInputan) && $formInputan->tipe_field === 'textarea') ? 'selected' : '' }}>Textarea</option>
                <option value="integer" {{ (isset($formInputan) && $formInputan->tipe_field === 'integer') ? 'selected' : '' }}>Integer</option>
            </select>
        </div>
        <div class="form-group">
            <label for="required">Required</label>
            <select name="required" id="required" class="form-control" required>
                <option value="1" {{ (isset($formInputan) && $formInputan->required) ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ (isset($formInputan) && !$formInputan->required) ? 'selected' : '' }}>No</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
