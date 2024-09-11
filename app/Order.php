<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function bar()
    {
        return $this->hasOne(Bar::class, 'id', 'bar_id');
    }

    public function status()
    {
        return $this->hasOne(OrderStatus::class, 'id', 'status_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($order) {
            $order->items()->delete();
        });
    }
}
