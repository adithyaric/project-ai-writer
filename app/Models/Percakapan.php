<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Percakapan extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'layanan_id', 'judul', 'form_data'];

    // Store form_data as JSON
    protected $casts = [
        'form_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class);
    }
}
