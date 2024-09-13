<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'innovation_id',
        'criterio_id',
        'puntaje',
        'comentario'
    ];

    public function innovation()
    {
        return $this->belongsTo(Innovation::class);
    }

    public function criterio()
    {
        return $this->belongsTo(Criterio::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 
