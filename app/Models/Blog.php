<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $guarded=['id'];
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
