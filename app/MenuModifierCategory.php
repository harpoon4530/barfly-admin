<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuModifierCategory extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(MenuModifierItem::class, 'mod_cat_id', 'id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($menu_modifier_category) {
            $menu_modifier_category->items()->delete();
        });
    }
}
