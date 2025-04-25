<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormInputan extends Model
{
    use SoftDeletes;

    protected $fillable = ['layanan_id', 'nama_field', 'tipe_field', 'required'];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}
