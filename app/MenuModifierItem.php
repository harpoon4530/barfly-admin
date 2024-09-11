<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuModifierItem extends Model
{
    protected $guarded = [];

    public function modifier_category()
    {
        return $this->hasOne(MenuModifierCategory::class, 'id', 'mod_cat_id');
    }
}
