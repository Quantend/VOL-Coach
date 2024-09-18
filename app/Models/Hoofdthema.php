<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hoofdthema extends Model
{
    protected $fillable = ['naam', 'beschrijving'];

    public function deelthemas()
    {
        return $this->hasMany(Deelthema::class);
    }
}
