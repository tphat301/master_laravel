<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
  use HasFactory;
  protected $primaryKey = 'id_district ';
  protected $table = 'district';
  protected $fillable = ['code_district', 'name_district', 'type_district', 'code_city', 'num', 'created_at', 'updated_at'];
}
