<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
  use Notifiable;
  protected $fillable = [
    'name',
    'email',
    'username',
    'password'
  ];
  protected $hidden = [
    'password',
    'remember_token'
  ];
}
