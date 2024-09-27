<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Home extends Model
{
    protected $table = 'home';

    protected $fillable = ['content', 'media'];

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($home) {
            if ($home->content) {
                self::deleteFilesFromContent($home->content);
            }
        });

        static::updating(function ($home) {
            $originalContent = $home->getOriginal('content');
            $updatedContent = $home->content;

            if ($originalContent !== $updatedContent) {
                self::deleteFilesFromContent($originalContent);
            }
        });
    }

    protected static function deleteFilesFromContent($content)
    {
        $pattern = '/(?:https?:\/\/[^\/]+\/storage\/|..\/storage\/)([^\s"\'<>]+)/i';

        preg_match_all($pattern, $content, $matches);

        foreach ($matches[1] as $filePath) {
            if (strpos($filePath, '../') === 0) {
                $filePath = str_replace('../storage/', '', $filePath);
            }

            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }
    }
}
