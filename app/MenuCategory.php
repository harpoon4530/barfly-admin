<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(MenuItem::class, 'cat_id', 'id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($menu_category) {
            $menu_category->items()->delete();
        });
    }
}
