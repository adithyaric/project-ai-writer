<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jawaban extends Model
{
    use SoftDeletes;

    protected $fillable = ['pertanyaan_id', 'isi_jawaban'];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }
}
