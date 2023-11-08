<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $appends = ['role_label'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'institution_id',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function institution(){
        return $this->belongsTo(Institution::class);
    }

    public function institutions(){
        return $this->belongsToMany(
            Institution::class,
            'user_institutions',
        );
    }

    public function user_institutions(){
        return $this->hasMany(UserInstitution::class);
    }

    public function getRoleLabelAttribute(){
        if(isset($this->attributes['role_id'])){
            switch ($this->attributes['role_id']){
                case 1: return 'Superadmin';
                case 2: return 'Admin Institusi';
                case 3: return 'Admin Project';
                case 4: return 'Project Input';
            }
        }
    }
}
