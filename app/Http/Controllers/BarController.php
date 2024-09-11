<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bar;
use App\MenuModifierCategory;

class BarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bars = Bar::all();
        return view('bars.index',[
            'bars' => $bars
        ]);
    }

    public function create()
    {
        return view('bars.create');
    }

    public function store(Request $request)
    {
        Bar::create([
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'lat' => $request->latitude,
            'lon' => $request->longitude,
            'image' => $request->image->store('uploads', 'public'),
            'image_landscape' => $request->image_landscape->store('uploads', 'public')
        ]);

        return redirect('bars');
    }

    public function destroy($bar_id)
    {
        Bar::destroy($bar_id);
        return redirect('bars')->with('msg', 'Bar has been deleted successfully!');
    }

    public function edit($bar_id)
    {
        $bar = Bar::find($bar_id);
        
        return view('bars.edit', [
            'bar' => $bar,
        ]);
    }

    public function update(Request $request, $bar_id)
    {
        $bar = Bar::find($bar_id);
        $bar->name = $request->name;
        $bar->address = $request->address;
        $bar->city = $request->city;
        $bar->country = $request->country;
        $bar->lat = $request->latitude;
        $bar->lon = $request->longitude;
        $bar->image = $request->image->store('uploads', 'public');
        $bar->save();

        return redirect('bars')->with('msg', 'Bar has been edited successfully!');
    }

    public function show($bar_id)
    {
        $bar = Bar::find($bar_id);

        foreach ($bar->menu_categories as $cat) {
            foreach ($cat->items as $item) {
                $modifier_categories = MenuModifierCategory::findMany(json_decode($item->modifiers));
                $item->modifier_categories = $modifier_categories;
            }
        }

        return view('bars.show', [
            'bar' => $bar,
        ]);
    }

}
