<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiereCommande extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'biere_id',
        'commande_id',
        'quantite',
    ];
}
