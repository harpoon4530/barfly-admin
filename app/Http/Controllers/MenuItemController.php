<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MenuItem;
use App\MenuCategory;
use App\MenuItemType;
use App\MenuModifierCategory;

class MenuItemController extends Controller
{
    public function create($bar_id, $cat_id)
    {
        $menu_category = MenuCategory::where('id', '=', $cat_id)->first();
        $menu_item_types = MenuItemType::all();
        $menu_modifier_categories = MenuModifierCategory::where('bar_id', '=', $bar_id)->get();

        return view('menu.items.create',[
            'bar_id' => $bar_id,
            'cat_id' => $cat_id,
            'menu_category' => $menu_category,
            'menu_item_types' => $menu_item_types,
            'menu_modifier_categories' => $menu_modifier_categories
        ]);
    }
    
    public function store(Request $request, $bar_id, $cat_id)
    {
        $menu_items_types = MenuItemType::all();

        $types_json = '[';

        for ($i=0; $i<count($menu_items_types); $i++) {
            $price_id = 'price_' . ($i+1);
            $type_id = 'item_type_' . ($i+1);
            $modifiers_id = 'modifiers_' . ($i+1);

            if ( $request->exists($price_id) ) {
                $types_json .= '{"id":' . ($i+1) . ',"price":' . $request->get($price_id) . ',"type":"' . $request->get($type_id) . '","modifiers":"' . $request->get($modifiers_id) . '"},';
            }
        }

        if ( strlen($types_json) > 1 ) {
            $types_json = substr($types_json, 0, -1);
        }

        $types_json .= ']';

        $modifiers = '[';

        if ( $request->mod_cat_ids ) {
            $modifiers .= implode(', ', $request->mod_cat_ids);
        }

        $modifiers .= ']';

        MenuItem::create([
            'name' => $request->name,
            'types' => $types_json,
            'modifiers' => $modifiers,
            'currency' => $request->currency,
            'description' => $request->description,
            'image' => $request->image->store('uploads', 'public'),
            'bar_id' => $bar_id,
            'cat_id' => $cat_id
        ]);
        
        return redirect()->route('bar.show', $bar_id);
    }

    public function edit($bar_id, $cat_id, MenuItem $item)
    {
        $menu_category = MenuCategory::where('id', '=', $cat_id)->first();

        return view('menu.items.edit',[
            'bar_id' => $bar_id,
            'cat_id' => $cat_id,
            'menu_category' => $menu_category,
            'menu_item' => $item,
        ]);
    }

    public function update(Request $request, $bar_id, MenuItem $item)
    {
        $item->name = $request->name;
        $item->price = $request->price;
        $item->currency = $request->currency;
        $item->save();

        return redirect()->route('bar.show', $bar_id)->with('msg', 'Item has been edited successfully!');
    }

    public function destroy($bar_id, MenuItem $item)
    {
        $item->delete();
        return redirect()->route('bar.show', $bar_id)->with('msg', 'Item has been deleted successfully!');
    }
}
