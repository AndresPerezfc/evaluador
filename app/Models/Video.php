<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'proposito',
        'publico_objetivo',
        'plataformas',
        'url_video',
        'tipo_presentacion',
        'incrustable',
        'innovador',
        'identificacion',
        'email',
        'telefono',
        'rol_autor',
        'institucion_educativa',
        'departamento',
        'ciudad',
        'coautor',
        'puntaje',
        'extra_puntos',
        'comentario_general'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function evaluations()
    {
        return $this->hasMany(EvaluationVideo::class);
    }
}
