<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $guarded = [];

    public function bar()
    {
        return $this->hasOne(Bar::class, 'id', 'bar_id');
    }
}
