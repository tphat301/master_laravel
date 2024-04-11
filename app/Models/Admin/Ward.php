<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
  use HasFactory;
  protected $primaryKey = 'id_ward';
  protected $table = 'ward';
  protected $fillable = ['name_ward', 'type_ward', 'code_district', 'num', 'created_at', 'updated_at'];
}
