<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zelftoets extends Model
{
    protected $fillable = ['hoofdthema_id', 'user_id', 'uitslag'];

    protected $casts = ['uitslag' => 'array'];
}
