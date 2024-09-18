<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'video_id',
        'criterio_id',
        'puntaje',
        'comentario',
        'tipo'
    ];

    public function video()
    {
        return $this->belongsTo(Video::class);
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
