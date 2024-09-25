<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zelftoets extends Model
{
    protected $fillable = ['hoofdthema_id', 'deelthema_id', 'user_id', 'uitslag', 'uitdaging_id'];

    protected $casts = ['uitslag' => 'array'];
}
