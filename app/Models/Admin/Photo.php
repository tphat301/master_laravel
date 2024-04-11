<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
  use HasFactory;
  protected $primaryKey = 'id';
  protected $table = 'photo';
  protected $fillable = ['title', 'desc', 'content', 'photo', 'type', 'action', 'link', 'hash', 'status', 'num', 'position', 'created_at', 'updated_at'];
}
