<?php

namespace sis5cs;

use Illuminate\Database\Eloquent\Model;

class Reprogramados extends Model
{
    protected $table = 'reprogramados';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
          'id' ,
          'id_credito' ,
          'id_credito_rep' ,
          'id_usuario' ,
          'id_persona' ,
    ];

}
