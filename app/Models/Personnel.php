<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'dateNaiss',
        'lieuNaiss',
        'cin',
        'poste',
    ];

    //mutateur
    public function setMatriculeAttribute($value){
        return $this->attributes['matricule'] = strtoupper($value);
    }

    public function setNomAttribute($value){
        return $this->attributes['nom'] = strtoupper($value);
    }

    public function setPrenomAttribute($value){
        return $this->attributes['prenom'] = ucwords($value);
    }

    public function setLieuNaissAttribute($value){
        return $this->attributes['lieuNaiss'] = ucwords($value);
    }

    public function setPosteAttribute($value){
        return $this->attributes['poste'] = ucfirst($value);
    }
}


