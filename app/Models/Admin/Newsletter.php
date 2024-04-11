<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
  use HasFactory;
  protected $primaryKey = 'id';
  protected $table = 'newsletter';
  protected $fillable = ['fullname', 'file_attach', 'email', 'phone', 'subject', 'type', 'confirm_status', 'content', 'address', 'notes', 'num', 'created_at', 'updated_at'];
}
