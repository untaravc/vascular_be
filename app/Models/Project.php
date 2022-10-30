<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $appends = ['status_label'];

    public function institution(){
        return $this->belongsTo(Institution::class);
    }

    public function records(){
        return $this->hasMany(Record::class);
    }

    public function getStatusLabelAttribute(){
        if(isset($this->attributes['status'])){
            switch ($this->attributes['status']){
                case 1: return 'aktif';
                case 0: return 'non-aktif';
            }
        }
    }
}
