<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\MenuItem;
use App\MenuModifierItem;
use App\Order;
use App\OrderItem;
use App\Notification;
use App\User;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function get_orders($user_id) {
        $orders = Order::where('user_id', '=', $user_id)
            ->orderBy('id', 'DESC')
            ->get();

        // Fetch Order's relational items
        foreach ($orders as $order) {
            $order_items = $order->items;
            
            // ------- Uncomment below code to display images items wise ----- \\
            // foreach ($order_items as $order_item) {
            //     $menu_item = MenuItem::where('id', '=', $order_item->item_id)->first();
            //     $order_item->image = $menu_item->image;
            // }

            $order->bar;
            $order->status;
        }

        return $orders;
    }

    public function create_order() {
        try {
            $items = null;
            $order_items = array();
            $items = array();

            // Takes raw data from the request
            $json = file_get_contents('php://input');

            // Converts it into a PHP object
            $data = json_decode($json);

            for ($x=0; $x <count($data->order_items) ; $x++) { 
                array_push($items, MenuItem::find($data->order_items[$x]->id));
            }

            $order_id = Order::create([
                'bar_id' => $data->bar_id,
                'user_id' => $data->user_id,
                'table_no' => $data->table_no,
                'comments' => $data->comments
            ])->id;

            foreach( $items as $key => $item ) {
                $decoded_types = json_decode($item->types);

                $selected_item_price = 0;
                $selected_item_type = null;
                $selected_modifiers = array();

                for ($i=0; $i < count($decoded_types); $i++) {

                    if ( $decoded_types[$i]->id == $data->order_items[$key]->type_id ) {
                        $selected_item_price = $decoded_types[$i]->price;
                        $selected_item_type = $decoded_types[$i]->type;

                        if ( $decoded_types[$i]->modifiers == 'Yes') {
                            
                            for ( $k=0; $k < count($data->order_items[$key]->modifier_ids); $k++ ) {
                                $selected_modifier = $data->order_items[$key]->modifier_ids[$k];
    
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
                    'quantity' => $data->order_items[$key]->quantity,
                    'category' => $item->category->name,
                    'item_id' => $item->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ));
            }

            OrderItem::insert($order_items);

            $recent_order = Order::find($order_id);
            $recent_order->items;
            $recent_order->bar;
            $recent_order->status;

            return array(
                'msg' => 'Order has been successfully placed',
                'order' => $recent_order
            );
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update_order_status(Request $request) {
        $order = Order::find($request->order_id);
        $order->status_id = $request->status_id;
        $order->save();

        $padded_order_id = sprintf("%06d", $request->order_id);

        $notification = Notification::where('order_id', '=', $request->order_id)->first();

        if ($notification === null) {
            // Insert new record into database
            Notification::insert([
                'user_id' => $order->user_id,
                'order_id' => $request->order_id,
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

        $this->send_push_notification($order->user_id, $request->order_id, 'Your order ' . $padded_order_id . ' is ' . $order->status->name);
        
        return array('msg' => 'Order status has been successfully updated');
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
