<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validatie extends Model
{
    protected $table = 'validatie';

    protected $fillable = ['deelthema_id', 'user_id', 'uitdaging_id', 'validatie_antwoord'];
}
