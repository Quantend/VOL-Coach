<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Hoofdthema extends Model
{
    protected $fillable = ['naam', 'beschrijving', 'content', 'media'];

    public function deelthemas()
    {
        return $this->hasMany(Deelthema::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($hoofdthema) {
            if ($hoofdthema->content) {
                self::deleteFilesFromContent($hoofdthema->content);
            }
        });

        static::updating(function ($hoofdthema) {
            $originalContent = $hoofdthema->getOriginal('content');
            $updatedContent = $hoofdthema->content;

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
