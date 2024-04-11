<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
  use HasFactory;
  protected $primaryKey = 'id';
  protected $table = 'setting';
  protected $fillable = ['title', 'mastertool', 'analytics', 'type', 'headjs', 'bodyjs', 'address', 'options'];
}
