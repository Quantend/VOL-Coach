<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Deelthema extends Model
{
    protected $fillable = ['naam', 'beschrijving', 'vragen', 'content', 'hoofdthema_id', 'media'];

    protected $casts = ['vragen' => 'array'];

    public function hoofdthema()
    {
        return $this->belongsTo(Hoofdthema::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($deelthema) {
            if ($deelthema->content) {
                self::deleteFilesFromContent($deelthema->content);
            }
        });

        static::updating(function ($deelthema) {
            $originalContent = $deelthema->getOriginal('content');
            $updatedContent = $deelthema->content;

            if ($originalContent !== $updatedContent) {
                self::deleteFilesFromContent($originalContent);
            }
        });
    }

    protected static function deleteFilesFromContent($content)
    {
        $pattern = '/(https?:\/\/[^\/]+\/storage\/[^\s"\'<>]+)/i';

        preg_match_all($pattern, $content, $matches);

        foreach ($matches[1] as $fileUrl) {
            $filePath = preg_replace('/https?:\/\/[^\/]+\/storage\//', '', $fileUrl);

            Storage::disk('public')->delete($filePath);
        }
    }

}
