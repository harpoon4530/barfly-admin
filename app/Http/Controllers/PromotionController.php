<?php

namespace App\Http\Controllers;

use App\Bar;
use App\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $promotions = Promotion::all();
        return view('promotions.index', [
            'promotions' => $promotions
        ]);
    }

    public function create()
    {
        $bars = Bar::all();

        return view('promotions.create', [
            'bars' => $bars
        ]);
    }

    public function store(Request $request)
    {
        Promotion::create([
            'title' => $request->title,
            'bar_id' => $request->bar_id,
            'image' => $request->image->store('uploads', 'public')
        ]);

        return redirect('promotions');
    }

    public function show(Promotion $promotion)
    {
        //
    }

    public function edit(Promotion $promotion)
    {
        //
    }

    public function destroy($promo_id)
    {
        Promotion::destroy($promo_id);
        return redirect('promotions')->with('msg', 'Promotion has been deleted successfully!');
    }
}
