<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Layanan extends Model
{
    use SoftDeletes;

    protected $fillable = ['nama'];

    public function instruksiPrompt()
    {
        return $this->hasOne(InstruksiPrompt::class);
    }

    public function formInputan()
    {
        return $this->hasMany(FormInputan::class);
    }

    public function percakapan()
    {
        return $this->hasMany(Percakapan::class);
    }
}
