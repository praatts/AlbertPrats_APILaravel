<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animals extends Model
{
    protected $primaryKey = 'id_animal';
   protected $table = 'animals';
   public $timestamps = false;
   protected $fillable = [
      'nombre',
      'tipo',
      'peso',
      'enfermedad',
      'comentarios',
      'owner_id',
   ];
}
