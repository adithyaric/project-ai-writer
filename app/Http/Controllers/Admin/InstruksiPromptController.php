<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstruksiPrompt;
use App\Models\Layanan;
use Illuminate\Http\Request;

class InstruksiPromptController extends Controller
{
    public function edit($id)
    {
        $layanan = Layanan::find($id);
        $instruksiPrompt = $layanan->instruksiPrompt;

        return view('admin.instruksi-prompt.create-edit', compact('layanan', 'instruksiPrompt'));
    }

    public function update(Request $request, $id)
    {
        $layanan = Layanan::find($id);
        $request->validate(['prompt_text' => 'required|string']);
        InstruksiPrompt::updateOrCreate([
            'layanan_id' => $layanan->id,
        ], [
            'prompt_text' => $request->prompt_text,
        ]);

        return redirect()->route('layanan.index')->with('success', 'Instruksi Prompt updated successfully');
    }
}
