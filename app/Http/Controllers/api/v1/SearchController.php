<?php

namespace App\Http\Controllers\api\v1;

use App\Bar;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
  
    public function search_result($search) {

        $bars = Bar::select('bars.*')
           ->Join('menu_categories', 'bars.id', '=', 'menu_categories.bar_id')
           ->Join('menu_items', 'bars.id', '=', 'menu_items.bar_id')
           ->where('bars.name', 'like', '%'.$search.'%')
           ->orWhere('menu_categories.name', 'like', '%'.$search.'%')
           ->orWhere('menu_items.name', 'like', '%'.$search.'%')
           ->groupBy('bars.id')
           ->get();
        
        if ($bars === null) {
            return response()->json(['error' => 'No search result found'], 404);
        }

        return $bars;
     }
}