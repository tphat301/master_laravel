<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagProduct extends Model
{
  use HasFactory;
  protected $primaryKey = 'id_tag_product';
  protected $table = 'tag_product';
  protected $fillable = ['id_parent', 'id_tag', 'type_tag_product'];
}
