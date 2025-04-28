<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormInputan;
use App\Models\Layanan;
use Illuminate\Http\Request;

class FormInputanController extends Controller
{
    public function index(Layanan $layanan)
    {
        $formInputans = $layanan->formInputan;

        return view('admin.form-inputan.index', compact('layanan', 'formInputans'));
    }

    public function create(Layanan $layanan)
    {
        return view('admin.form-inputan.create-edit', compact('layanan'));
    }

    public function store(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nama_field' => 'required|string|max:255',
            'tipe_field' => 'required|string|in:string,textarea,integer',
            'required' => 'required|boolean',
        ]);

        $layanan->formInputan()->create($request->all());

        return redirect()->route('form-inputan.index', $layanan)->with('success', 'Form Inputan created successfully');
    }

    public function edit(FormInputan $formInputan)
    {
        return view('admin.form-inputan.create-edit', compact('formInputan'));
    }

    public function update(Request $request, FormInputan $formInputan)
    {
        $request->validate([
            'nama_field' => 'required|string|max:255',
            'tipe_field' => 'required|string|in:string,textarea,integer',
            'required' => 'required|boolean',
        ]);

        $formInputan->update($request->all());

        return redirect()->route('form-inputan.index', $formInputan->layanan_id)->with('success', 'Form Inputan updated successfully');
    }

    public function destroy(FormInputan $formInputan)
    {
        $formInputan->delete();

        return redirect()->route('form-inputan.index', $formInputan->layanan_id)->with('success', 'Form Inputan deleted successfully');
    }
}
