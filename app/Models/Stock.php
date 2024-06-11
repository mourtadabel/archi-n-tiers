<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['biere_id', 'quantite_stock'];

    public function biere()
    {
        return $this->belongsTo(Biere::class);
    }
}
