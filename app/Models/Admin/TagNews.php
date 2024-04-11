<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagNews extends Model
{
  use HasFactory;
  protected $primaryKey = 'id_tag_news';
  protected $table = 'tag_news';
  protected $fillable = ['id_parent', 'id_tag', 'type_tag_news'];
}
