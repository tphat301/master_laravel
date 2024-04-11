<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
  use HasFactory;
  protected $primaryKey = 'id';
  protected $table = 'visitor';
  protected $fillable = ['ip', 'tm'];
}
