<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'order';
    protected $fillable = ['id_user', 'code', 'fullname', 'phone', 'address', 'payments', 'email', 'city', 'district', 'ward', 'total_price', 'ship_price', 'requirements', 'notes', 'num', 'order_status', 'type', 'created_at', 'updated_at'];
}
