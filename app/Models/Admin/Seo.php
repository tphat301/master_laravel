<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
  use HasFactory;
  protected $primaryKey = 'id';
  protected $table = 'seo';
  protected $fillable = ['id_parent', 'type', 'hash_seo', 'title_seo', 'keywords', 'description_seo', 'schema', 'created_at', 'updated_at'];
}
