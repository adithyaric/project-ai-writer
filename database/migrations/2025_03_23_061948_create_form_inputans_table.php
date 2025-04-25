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
        Schema::create('form_inputans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Layanan::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('nama_field')->nullable();
            $table->string('tipe_field')->nullable();
            $table->boolean('required')->nullable()->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_inputans');
    }
};
