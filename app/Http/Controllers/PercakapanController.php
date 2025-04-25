<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Layanan;
use App\Models\Percakapan;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PercakapanController extends Controller
{
    public function index()
    {
        $percakapan = Percakapan::get();

        return view('percakapan.index', compact('percakapan'));
    }

    public function create()
    {
        $layanan = Layanan::all();

        return view('percakapan.create', compact('layanan'));
    }

    public function getFormInputan($id)
    {
        $layanan = Layanan::with('formInputan')->findOrFail($id);

        return response()->json($layanan->formInputan);
    }

    public function store(Request $request)
    {
        // Validate the base required data
        $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'judul' => 'required|string|max:255',
        ]);

        // Get layanan and its form inputs
        $layanan = Layanan::with('formInputan')->findOrFail($request->layanan_id);

        // Validate dynamic form fields
        $formRules = [];
        foreach ($layanan->formInputan as $input) {
            $fieldName = 'form_'.$input->id;
            $rule = $input->required ? 'required' : 'nullable';

            // Add type validation based on tipe_field
            switch ($input->tipe_field) {
                case 'integer':
                    $rule .= '|integer';
                    break;
                case 'numeric':
                case 'float':
                    $rule .= '|numeric';
                    break;
                case 'date':
                    $rule .= '|date';
                    break;
                default:
                    $rule .= '|string';
            }

            $formRules[$fieldName] = $rule;
        }

        $validatedData = $request->validate($formRules);

        // Prepare form data to be stored as JSON
        $formData = [];
        foreach ($layanan->formInputan as $input) {
            $fieldName = 'form_'.$input->id;
            if (isset($validatedData[$fieldName])) {
                $formData[$input->nama_field] = $validatedData[$fieldName];
            }
        }

        // Create new percakapan
        $percakapan = new Percakapan;
        $percakapan->user_id = Auth::id();
        $percakapan->layanan_id = $request->layanan_id;
        $percakapan->judul = $request->judul;
        $percakapan->form_data = $formData;
        $percakapan->save();

        // Generate AI response
        try {
            // Get the instruksi prompt from the layanan
            $instruksiPrompt = $percakapan->layanan->instruksiPrompt;
            $promptText = $instruksiPrompt ? $instruksiPrompt->prompt_text : '';

            // Replace placeholders in the prompt_text with actual form data
            foreach ($percakapan->form_data as $field => $value) {
                $placeholder = '{'.$field.'}';
                $promptText = str_replace($placeholder, $value, $promptText);
            }

            // Combine the prompt with form data for context
            $contextData = [
                'prompt' => $promptText,
                'form_data' => $percakapan->form_data,
                // 'question' => $request->isi_pertanyaan,
            ];

            // Save the question
            $pertanyaan = new Pertanyaan;
            $pertanyaan->percakapan_id = $percakapan->id;
            $pertanyaan->isi_pertanyaan = json_encode($contextData);
            $pertanyaan->save();

            // Call Ollama API with retry mechanism
            $retryCount = 0;
            $maxRetries = 3;
            $aiResponseText = 'Failed to generate AI response. Please try again later.';

            set_time_limit(120);

            while ($retryCount < $maxRetries) {
                try {
                    \Log::info('Sending request to Ollama API with context:', $contextData);

                    $aiResponse = Http::timeout(120)->post('http://localhost:11434/api/generate', [
                        'model' => 'gemma:2b',
                        'prompt' => json_encode($contextData),
                        'stream' => false,
                    ]);

                    \Log::info('Ollama API response:', $aiResponse->json());

                    if ($aiResponse->failed()) {
                        throw new \Exception('Ollama API request failed: '.$aiResponse->body());
                    }

                    $responseData = $aiResponse->json();
                    $aiResponseText = $responseData['response'] ?? 'No response received from AI model';
                    // Save the AI response as the first jawaban
                    $jawaban = new Jawaban;
                    $jawaban->pertanyaan_id = $pertanyaan->id;
                    $jawaban->isi_jawaban = $aiResponseText;
                    $jawaban->save();
                    break; // Exit the loop if successful
                } catch (\Exception $e) {
                    $retryCount++;
                    \Log::warning("Attempt $retryCount failed: ".$e->getMessage());
                    if ($retryCount === $maxRetries) {
                        \Log::error('All retry attempts failed.');
                    }
                }
            }

        } catch (\Exception $e) {
            // Log the error but don't fail the entire operation
            \Log::error('AI response generation failed: '.$e->getMessage());
        }

        return redirect()->route('percakapan.show', $percakapan->id)
            ->with('success', 'Percakapan berhasil dibuat');
    }

    public function show($id)
    {
        $percakapan = Percakapan::with(['pertanyaan.jawaban', 'layanan'])->findOrFail($id);

        // Check if user owns this conversation
        // if ($percakapan->user_id != Auth::id()) {
        // abort(403, 'Unauthorized action.');
        // }

        return view('percakapan.show', compact('percakapan'));
    }

    public function saveChat(Request $request, $id)
    {
        $request->validate([
            'isi_pertanyaan' => 'required|string',
        ]);

        $percakapan = Percakapan::findOrFail($id);

        // Check if user owns this conversation
        // if ($percakapan->user_id != Auth::id()) {
        // abort(403, 'Unauthorized action.');
        // }

        // Save the question
        $pertanyaan = new Pertanyaan;
        $pertanyaan->percakapan_id = $percakapan->id;
        $pertanyaan->isi_pertanyaan = $request->isi_pertanyaan;
        $pertanyaan->save();

        // Here you would make API call to AI service
        // This is a placeholder for your actual AI integration
        // Actual API call to local Ollama service
        try {
            $aiResponse = Http::timeout(120)->post('http://localhost:11434/api/generate', [
                'model' => 'gemma:2b',
                'prompt' => $request->isi_pertanyaan,
                'stream' => false,
            ]);

            // Check for HTTP errors
            if ($aiResponse->failed()) {
                throw new \Exception('Ollama API request failed: '.$aiResponse->body());
            }

            $responseData = $aiResponse->json();
            $aiResponseText = $responseData['response'] ?? 'No response received from AI model';

            // Save the answer
            $jawaban = new Jawaban;
            $jawaban->pertanyaan_id = $pertanyaan->id;
            $jawaban->isi_jawaban = $aiResponseText;
            $jawaban->save();

            return response()->json([
                'status' => 'success',
                'pertanyaan' => $pertanyaan,
                'jawaban' => $jawaban,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get AI response: '.$e->getMessage(),
            ], 500);
        }
    }
}
