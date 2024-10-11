<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'payment_date', // nếu bạn có trường này
        // các thuộc tính khác nếu cần
    ];

    // Mối quan hệ với model Order
    public function order()
    {
        return $this->belongsTo(Order::class); // Một thanh toán thuộc về một đơn hàng
    }
}