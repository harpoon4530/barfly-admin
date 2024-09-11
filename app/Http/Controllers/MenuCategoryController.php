<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MenuCategory;

class MenuCategoryController extends Controller
{
    public function create($bar_id)
    {
        return view('menu.categories.create',[
            'bar_id' => $bar_id,
        ]);
    }
    
    public function store(Request $request, $bar_id)
    {
        MenuCategory::create([
            'name' => $request->name,
            'bar_id' => $bar_id,
        ]);
        return redirect()->route('bar.show', $bar_id);
    }

    public function destroy($bar_id, $cat_id)
    {
        MenuCategory::destroy($cat_id);
        return redirect()->route('bar.show', $bar_id)->with('msg', 'Category has been deleted successfully!');
    }
}
