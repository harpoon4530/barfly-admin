<?php

namespace App\Http\Controllers;

use App\MenuModifierCategory;
use App\MenuModifierItem;
use Illuminate\Http\Request;

class MenuModifierItemController extends Controller
{
    public function create($bar_id, $cat_id)
    {
        $menu_modifier_category = MenuModifierCategory::where('id', '=', $cat_id)->first();

        return view('menu.modifiers.items.create',[
            'bar_id' => $bar_id,
            'cat_id' => $cat_id,
            'menu_modifier_category' => $menu_modifier_category
        ]);
    }

    public function edit($bar_id, $cat_id, MenuModifierItem $item)
    {
        $menu_category = MenuModifierCategory::where('id', '=', $cat_id)->first();

        return view('menu.modifiers.items.edit',[
            'bar_id' => $bar_id,
            'cat_id' => $cat_id,
            'menu_category' => $menu_category,
            'menu_item' => $item
        ]);
    }

    public function update(Request $request, $bar_id, MenuModifierItem $item)
    {
        $item->name = $request->name;
        $item->save();

        return redirect()->route('bar.show', $bar_id)->with('msg_modifier', 'Item has been edited successfully!');
    }

    public function store(Request $request, $bar_id, $cat_id)
    {
        MenuModifierItem::create([
            'name' => $request->name,
            'bar_id' => $bar_id,
            'mod_cat_id' => $cat_id
        ]);
        
        return redirect()->route('bar.show', $bar_id);
    }

    public function destroy($bar_id, MenuModifierItem $item)
    {
        $item->delete();
        return redirect()->route('bar.show', $bar_id)->with('msg_modifier', 'Item has been deleted successfully!');
    }
}
