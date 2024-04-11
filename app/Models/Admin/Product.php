<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use HasFactory;
  protected $primaryKey = 'id';
  protected $table = 'products';
  protected $fillable = ['id_parent1', 'id_parent2', 'id_parent3', 'id_parent4', 'id_brand', 'slug', 'photo1', 'photo2', 'photo3', 'photo4', 'code', 'file_attach', 'file_youtube', 'file_mp4', 'status', 'type', 'num', 'hash', 'quantity', 'title', 'sale_price', 'regular_price', 'desc', 'content', 'discount', 'options', 'created_at', 'updated_at'];
}
