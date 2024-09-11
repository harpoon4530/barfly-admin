<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bar extends Model
{
    protected $guarded = [];

    public function menu_categories()
    {
        return $this->hasMany(MenuCategory::class, 'bar_id', 'id');
    }

    public function menu_modifier_categories()
    {
        return $this->hasMany(MenuModifierCategory::class, 'bar_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'bar_id', 'id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($bar) {
            foreach( $bar->menu_categories as $cat ) {
                $cat->items()->delete();
            }
            foreach( $bar->menu_modifier_categories as $mod_cat ) {
                $mod_cat->items()->delete();
            }
            foreach( $bar->orders as $order ) {
                $order->items()->delete();
            }

            $bar->menu_categories()->delete();
            $bar->menu_modifier_categories()->delete();
            $bar->orders()->delete();
        });
    }
}
