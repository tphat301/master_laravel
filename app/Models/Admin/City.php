<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
  use HasFactory;
  protected $primaryKey = 'id_city';
  protected $table = 'city';
  protected $fillable = ['code_city', 'name_city', 'type_city', 'code_city', 'num', 'created_at', 'updated_at'];
}
