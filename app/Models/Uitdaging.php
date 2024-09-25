<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uitdaging extends Model
{
    protected $fillable = ['deelthema_id', 'niveau', 'opdrachten'];

    protected $casts = ['opdrachten' => 'array'];

    public function deelthema()
    {
        return $this->belongsTo(Deelthema::class);
    }
}
