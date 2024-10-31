<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creation extends Model
{
    use HasFactory;

    protected $fillable = [
        'rol_autor',
        'categoria_autor',
        'titulo',
        'tematica',
        'problematica',
        'presentacion',
        'innovador',
        'identificación',
        'email',
        'perfil_instagram',
        'telefono',
        'vinculacion',
        'dependencia',
        'facultad',
        'programa',
        'colegio',
        'coautor',
        'puntaje',
        'comentario_general',
        'link_creation',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function evaluations()
    {
        return $this->hasMany(EvaluationCreation::class);
    }
}
