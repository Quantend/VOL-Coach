<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Deelthema extends Model
{
    protected $fillable = ['naam', 'beschrijving', 'vragen', 'content', 'hoofdthema_id', 'media'];

    public function hoofdthema()
    {
        return $this->belongsTo(Hoofdthema::class);
    }

    protected static function booted()
    {
        static::deleting(function ($deelthema) {
            // Controleer of er een bestand is gekoppeld
            if ($deelthema->media) {
                // Verwijder het bestand van de schijf
                Storage::disk('public')->delete($deelthema->media);
            }
        });

        static::updating(function ($deelthema) {
            $originalMedia = $deelthema->getOriginal('media');

            // Controleer of er een nieuw bestand wordt geüpload en er al een bestaand bestand is
            if ($originalMedia && $deelthema->media !== $originalMedia) {
                // Verwijder het oude bestand
                Storage::disk('public')->delete($originalMedia);
            }
        });
    }

    protected $casts = [
        'vragen' => 'array',
    ];

}
