<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pertanyaan extends Model
{
    use SoftDeletes;

    protected $fillable = ['percakapan_id', 'isi_pertanyaan'];

    public function percakapan()
    {
        return $this->belongsTo(Percakapan::class);
    }

    public function jawaban()
    {
        return $this->hasOne(Jawaban::class);
    }
}
