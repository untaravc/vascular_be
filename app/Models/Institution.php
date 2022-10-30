<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $appends = ['status_label'];

    public function getStatusLabelAttribute(){
        if(isset($this->attributes['status'])){
            switch ($this->attributes['status']){
                case 1: return 'Active';
                case 0: return 'Non Active';
            }
        }
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function projects(){
        return $this->hasMany(Project::class);
    }
}
