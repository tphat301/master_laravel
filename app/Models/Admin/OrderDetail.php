<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'order_detail';
    protected $fillable = ['id_product', 'photo', 'title', 'code', 'color', 'size', 'regular_price', 'sale_price', 'quantity', 'created_at', 'updated_at'];
}
