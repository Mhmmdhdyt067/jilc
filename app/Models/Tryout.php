<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tryout extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }
}
