<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deelthema extends Model
{
    protected $fillable = ['naam', 'beschrijving', 'vragen', 'content', 'hoofdthema_id', 'media'];

    public function hoofdthema()
    {
        return $this->belongsTo(Hoofdthema::class);
    }

    protected $casts = [
        'vragen' => 'array',
    ];

}
