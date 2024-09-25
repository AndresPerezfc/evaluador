<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InnovationComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'innovation_id',
        'comentario',
    ];

    public function innovation()
    {
        return $this->belongsTo(Video::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
