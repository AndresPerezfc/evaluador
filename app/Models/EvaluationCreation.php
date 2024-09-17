<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCreation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'creation_id',
        'criterio_id',
        'puntaje',
        'comentario',
        'tipo'
    ];

    public function creation()
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
