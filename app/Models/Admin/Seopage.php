<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seopage extends Model
{
  use HasFactory;
  protected $primaryKey = 'id';
  protected $table = 'seopage';
  protected $fillable = ['title', 'type', 'photo', 'keywords', 'description', 'hash', 'created_at', 'updated_at'];
}
