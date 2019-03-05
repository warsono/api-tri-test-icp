<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Posts extends Authenticatable
{
    use HasApiTokens, Notifiable;
    
    protected $fillable = [
        'title', 'content', 'created_by', 'updated_by',
    ];
    
}
