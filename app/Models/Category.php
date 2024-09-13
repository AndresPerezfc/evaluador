<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Definir los campos asignables
    protected $fillable = [
        'name',
        'description',
    ];

    // Relación uno a muchos: una categoría tiene muchas innovaciones
    public function innovations()
    {
        return $this->hasMany(Innovation::class);
    }
}
