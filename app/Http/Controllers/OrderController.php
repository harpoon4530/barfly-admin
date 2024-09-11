<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Bar;
use App\MenuItem;
use App\MenuModifierCategory;
use App\MenuModifierItem;
use App\OrderItem;
use App\OrderStatus;
use App\Notification;
use App\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->get();
        $order_statuses = OrderStatus::all();

        return view('orders.index',[
            'orders' => $orders,
            'order_statuses' => $order_statuses
        ]);
    }

    public function create()
    {
        $bars = Bar::all();

        foreach ($bars as $bar) {
            $menu_categories = $bar->menu_categories;
            foreach ($menu_categories as $category) {
                $category->items;
            }
        }
        
        return view('orders.create', [
            'bars' => $bars,
        ]);
    }

    public function store(Request $request)
    {
        $items = null;
        $order_items = array();
        $item_ids = array();

        $order_id = Order::create([
            'bar_id' => $request->bar_id,
            'user_id' => Auth::user()->id
        ])->id;

        for ($i=0; $i < $request->dynamic_count; $i++) { 
            $item_id = 'item_' . ($i+1);
            array_push($item_ids, $request->get($item_id));
        }

        $items = array();

        for ($x=0; $x <count($item_ids) ; $x++) { 
            array_push($items, MenuItem::find($item_ids[$x]));
        }

        foreach ( $items as $key => $item ) {
            $type_id = 'type_' . ($key+1);
            $selected_type = $request->get($type_id);

            $quantity_id = 'quantity_' . ($key+1);
            $selected_item_quantity = $request->get($quantity_id);

            $decoded_types = json_decode($item->types);
            
            $selected_item_price = 0;
            $selected_item_type = null;
            $selected_modifiers = array();
            
            for ($i=0; $i < count($decoded_types); $i++) {

                if ( $decoded_types[$i]->id == $selected_type ) {
                    $selected_item_price = $decoded_types[$i]->price;
                    $selected_item_type = $decoded_types[$i]->type;
                    
                    if ( $decoded_types[$i]->modifiers == 'Yes') {

                        $modifier_dynamic_id = 'dynamic_modifier_' . ($key+1);
                        $modifier_dynamic_count = $request->get($modifier_dynamic_id);
                        
                        for ( $k=0; $k < $modifier_dynamic_count; $k++ ) {
                            $modifier_id = 'modifiers_' . ($key+1) . '_' . ($k+1);
                            $selected_modifier = $request->get($modifier_id);

                            $menu_modi_item = MenuModifierItem::find($selected_modifier);

                            $obj_modifiers = array(
                                'category' => array(
                                    'id' => $menu_modi_item->modifier_category->id,
                                    'name' => $menu_modi_item->modifier_category->name
                                ),
                                'modifier' => array(
                                    'id' => $menu_modi_item->id,
                                    'name' => $menu_modi_item->name
                                )
                            );
    
                            array_push($selected_modifiers, $obj_modifiers);
                        }
                        
                    }
                }
            }

            array_push($order_items, array(
                'name' => $item->name,
                'price' => $selected_item_price,
                'currency' => $item->currency,
                'type' => $selected_item_type,
                'modifiers' => json_encode($selected_modifiers),
                'order_id' => $order_id,
                'quantity' => $selected_item_quantity,
                'category' => $item->category->name,
                'item_id' => $item->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ));
        }
        
        OrderItem::insert($order_items);

        return redirect('orders');
    }

    public function destroy($order_id)
    {
        Order::destroy($order_id);
        return redirect('orders')->with('msg', 'Order has been deleted successfully!');
    }

    public function update(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        $order->status_id = $request->status_id;
        $order->save();

        $padded_order_id = sprintf("%06d", $order_id);

        $notification = Notification::where('order_id', '=', $order_id)->first();

        if ($notification === null) {
            // Insert new record into database
            Notification::insert([
                'user_id' => $order->user_id,
                'order_id' => $order_id,
                'status_id' => $request->status_id,
                'msg' => 'Your order ' . $padded_order_id . ' is ' . $order->status->name,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            // Update the existing record
            $notification->msg = 'Your order ' . $padded_order_id . ' is ' . $order->status->name;
            $notification->save();
        }

        $this->send_push_notification($order->user_id, $order_id, 'Your order ' . $padded_order_id . ' is ' . $order->status->name);

        return array('msg' => 'Order ' . $order_id . ' status has been updated successfully!');
    }

    public function show($order_id)
    {
        $order = Order::find($order_id);
        
        return view('orders.show',[
            'order' => $order,
        ]);
    }

    public function get_menu_modifiers($bar_id)
    {
        $menu_modifiers = MenuModifierCategory::where('bar_id', '=', $bar_id)->get();
        
        foreach ($menu_modifiers as $item) {
            $item->items;
        }

        return $menu_modifiers;
    }

    private function send_push_notification($user_id, $order_id, $msg) {
        $user = User::find($user_id);

        $json_data = [
            "to" => $user->fcm_token,
            "collapse_key" => "type_a",
            "notification" => [
                "body" => $msg,
                "title" => "Barfly",
                "sound" => "default"
            ],
            "data" => [
                "order_id" => $order_id
            ]
        ];

        $data = json_encode($json_data);
        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AAAA45P2uhw:APA91bFL9UhWHsdkntb-64oUxBIogxuTuNwlufOYwSSfCmSiwFNFC596Dskp0iRzOL7_YyK4K7bj_5rzSG_ezKqsi73Vvbpn2b447SZ7JXAvFMdMUg5cZwk6myoU1dF-xBk6bgOKsr09';
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        //CURL request to route notification to FCM connection server (provided by Google)
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);

        if ($result === FALSE) {
            return array('msg' => 'Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
    }

}
