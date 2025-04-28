<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::with(['instruksiPrompt', 'formInputan'])->get();

        return view('admin.layanan.index', compact('layanans'));
    }

    public function create()
    {
        return view('admin.layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        Layanan::create($request->only('nama'));

        return redirect()->route('layanan.index')->with('success', 'Layanan created successfully');
    }

    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        $layanan->update($request->only('nama'));

        return redirect()->route('layanan.index')->with('success', 'Layanan updated successfully');
    }

    public function destroy(Layanan $layanan)
    {
        $layanan->delete();

        return redirect()->route('layanan.index')->with('success', 'Layanan deleted successfully');
    }
}
