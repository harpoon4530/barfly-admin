<?php

namespace App\Http\Controllers\api\v1;

use App\Bar;
use App\Http\Controllers\Controller;
use App\MenuModifierCategory;
use Illuminate\Http\Request;

class BarController extends Controller
{

    public function get_bars() {
        $bars = Bar::all();
        return $bars;
    }
    
    public function get_menu($bar_id) {
        $bar = Bar::find( $bar_id );
        $categories = $bar->menu_categories;

        foreach ($categories as $category) {
            $items = $category->items;

            foreach ($items as $item) {
                $item->modifiers = MenuModifierCategory::findMany(json_decode($item->modifiers));

                foreach ($item->modifiers as $modifier) {
                    $modifier->items = $modifier->items;
                }
            }
        }

        if ($bar === null) {
            return response()->json(['error' => 'Bar not found'], 404);
        }

        return $bar;
    }

    public function get_bar($bar_id) {
        $bar = Bar::find($bar_id);
        $orders = $bar->orders;

        // Fetch Order's relational items
        foreach ($orders as $order) {
            $order->items;
            $order->user;
            $order->status;
        }

        return $bar;
    }

    public function get_nearby(Request $request) {
        $bars = $this->get_bars();
        $nearby_bars = array();
        $radius_in_kms = 4;

        foreach ($bars as $bar) {
            if ( $this->distance($bar->lat, $bar->lon, $request->lat, $request->lon, 'K') <= $radius_in_kms ) {
                array_push($nearby_bars, $bar);
            }
        }
        
        return array('nearby_bars' => $nearby_bars);
    }

    private function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
      
        if ($unit == "K") {
          return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
              return $miles;
        }
    }

}