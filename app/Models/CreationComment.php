<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreationComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'creation_id',
        'comentario',
    ];

    public function creation()
    {
        return $this->belongsTo(Creation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
