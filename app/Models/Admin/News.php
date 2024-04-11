<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
  use HasFactory;
  protected $primaryKey = 'id';
  protected $table = 'news';
  protected $fillable = ['id_parent1', 'id_parent2', 'id_parent3', 'id_parent4', 'slug', 'photo1', 'photo2', 'photo3', 'photo4', 'file_attach', 'file_youtube', 'file_mp4', 'status', 'type', 'num', 'hash', 'quantity', 'title', 'desc', 'content', 'options', 'created_at', 'updated_at'];
}
