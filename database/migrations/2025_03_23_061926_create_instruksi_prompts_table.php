<?php

use App\Models\Layanan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('instruksi_prompts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Layanan::class)->nullable()->constrained()->cascadeOnDelete();
            $table->longText('prompt_text')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instruksi_prompts');
    }
};
