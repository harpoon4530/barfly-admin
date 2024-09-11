<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Promotion;

class PromotionController extends Controller
{

    public function get_promotions()
    {
        $promotions = Promotion::all();
        
        foreach ($promotions as $promotion) {
            $promotion->bar;
        }

        return $promotions;
    }

}
