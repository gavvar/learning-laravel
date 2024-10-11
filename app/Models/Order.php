<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        // các thuộc tính khác nếu cần
    ];

    // Mối quan hệ với model Payment
    public function payment()
    {
        return $this->hasOne(Payment::class); // Một đơn hàng có một thanh toán
    }

    // Mối quan hệ với model OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class); // Một đơn hàng có nhiều mục
    }
     // Mối quan hệ với model User
    public function user()
    {
        return $this->belongsTo(User::class); // Một đơn hàng thuộc về một người dùng
    }
}