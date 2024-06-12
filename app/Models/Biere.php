<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biere extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prix'];

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }   

    public function commandes()
    {
        return $this->belongsToMany(Commande::class)->withPivot('quantite');
    }
}
