<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
  use HasFactory;
  protected $primaryKey = 'id_tag';
  protected $table = 'tag';
  protected $fillable = ['title_tag', 'id_parent', 'photo', 'type_tag', 'num_tag', 'hash_tag', 'status_tag'];
}
