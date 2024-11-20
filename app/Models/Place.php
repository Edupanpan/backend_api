<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{   
    protected $table = 'places';
    protected $fillable = ['nombre', 'direccion', 'url_imagen', 'fecha_visita'];
    
}
