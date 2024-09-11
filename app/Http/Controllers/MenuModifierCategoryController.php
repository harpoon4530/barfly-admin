<?php

namespace App\Http\Controllers;

use App\MenuModifierCategory;
use Illuminate\Http\Request;

class MenuModifierCategoryController extends Controller
{
    public function create($bar_id)
    {
        return view('menu.modifiers.categories.create',[
            'bar_id' => $bar_id,
        ]);
    }

    public function store(Request $request, $bar_id)
    {
        MenuModifierCategory::create([
            'name' => $request->name,
            'bar_id' => $bar_id,
        ]);
        return redirect()->route('bar.show', $bar_id);
    }

    public function destroy($bar_id, $cat_id)
    {
        MenuModifierCategory::destroy($cat_id);
        return redirect()->route('bar.show', $bar_id)->with('msg_modifier', 'Modifier has been deleted successfully!');
    }
}
