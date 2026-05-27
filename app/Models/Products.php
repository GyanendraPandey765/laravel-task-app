<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //abhigyan pratap singh 27-05-2026
     protected $fillable = ['name', 'price','stock','description',"is_active"];
}
