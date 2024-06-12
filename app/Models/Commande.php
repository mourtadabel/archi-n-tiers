<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = ['valide'];

    public function bieres()
    {
        return $this->belongsToMany(Biere::class,'biere_commande', 'id_commande', 'id_biere');

    }
}
