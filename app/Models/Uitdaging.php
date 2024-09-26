<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Uitdaging extends Model
{
    protected $fillable = ['deelthema_id', 'niveau', 'opdrachten', 'validatie'];

    protected $casts = ['opdrachten' => 'array'];

    public function deelthema()
    {
        return $this->belongsTo(Deelthema::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($uitdaging) {
            if ($uitdaging->validatie) {
                self::deleteFilesFromContent($uitdaging->validatie);
            }
        });

        static::updating(function ($uitdaging) {
            $originalContent = $uitdaging->getOriginal('validatie');
            $updatedContent = $uitdaging->validatie;

            if ($originalContent !== $updatedContent) {
                self::deleteFilesFromContent($originalContent);
            }
        });
    }

    protected static function deleteFilesFromContent($fileName)
    {
        if ($fileName) {
            if (Storage::disk('public')->exists($fileName)) {
                Storage::disk('public')->delete($fileName);
            }
        }
    }
}
