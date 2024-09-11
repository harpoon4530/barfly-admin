<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
