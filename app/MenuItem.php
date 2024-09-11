<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->hasOne(MenuCategory::class, 'id', 'cat_id');
    }
}
