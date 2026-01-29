<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owners extends Model
{
   protected $primaryKey = 'id_persona';
   protected $table = 'owners';
   public $timestamps = false;
   protected $fillable = [
      'name',
      'surname',
   ];
}
