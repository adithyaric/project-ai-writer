<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstruksiPrompt extends Model
{
    use SoftDeletes;

    protected $fillable = ['layanan_id', 'prompt_text'];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}
