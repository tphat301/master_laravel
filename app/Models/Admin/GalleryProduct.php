<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryProduct extends Model
{
  use HasFactory;
  protected $primaryKey = 'id';
  protected $table = 'gallery';
  protected $fillable = ['id_parent', 'hash', 'photo', 'title', 'num', 'type', 'status', 'created_at', 'updated_at'];
}
