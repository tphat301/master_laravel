<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
  use HasFactory;
  protected $primaryKey = 'id';
  protected $table = 'category_products';
  protected $fillable = ['id_parent', 'level', 'title', 'photo1', 'photo2', 'photo3', 'photo4', 'type', 'status', 'slug', 'desc', 'content', 'options', 'num', 'hash', 'created_at', 'updated_at'];
}
