<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
  use HasFactory;
  protected $primaryKey = 'id';
  protected $table = 'page';
  protected $fillable = ['slogan', 'slug', 'title', 'type', 'status', 'hash', 'photo1', 'photo2', 'photo3', 'photo4', 'desc', 'content', 'file_attach', 'file_youtube', 'file_mp4', 'options', 'created_at', 'updated_at'];
}
