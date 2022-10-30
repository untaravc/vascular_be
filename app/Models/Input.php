<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Input extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function input_details(){
        return $this->hasMany(InputDetail::class);
    }
}
