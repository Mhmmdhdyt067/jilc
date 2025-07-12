<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];


    public function tryout()
    {
        return $this->belongsTo(Tryout::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
