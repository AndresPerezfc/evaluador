<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function evaluation()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function videoevaluation()
    {
        return $this->hasMany(EvaluationVideo::class);
    }
}
