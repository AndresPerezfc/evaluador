<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Innovation extends Model
{
    use HasFactory;

    protected $fillable = [
        'rol_autor',
        'categoria_autor',
        'titulo',
        'descripcion',
        'proceso',
        'url',
        'presentacion',
        'innovador',
        'identificación',
        'email',
        'perfil_instagram',
        'telefono',
        'vinculacion',
        'dependencia',
        'dependencia_aliada',
        'facultad',
        'programa',
        'colegio',
        'coautor',
        'comentario_general'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
