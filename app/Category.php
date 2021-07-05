<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{   //relazione con Post (1-*)
    public function posts(){
        return $this->hasMany('App\Post');
    }
}
