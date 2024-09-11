<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Payment;
use App\User;
use Exception;
use Stripe\StripeClient;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    private $stripe;

    private function load_stripe() {
        $this->stripe = new StripeClient(
            'sk_test_51OOKoPINOqQacwGxE7KOaOY2H2eWEgNqvaRmWA7sFY7UXs8ZIf9GOBLtIeDodlbrjL9g3J9i5YJ4cpH2rsZjlCvs00iZFa0Dma'
        );
    }

    public function create_customer(Request $request) {
        $this->load_stripe();

        $user = User::find($request->user_id);

        try {
            // Create a Customer:
            $response = $this->stripe->customers->create([
                'source' => $request->token,
                'email' => $user->email,
                'name' => $user->first_name . ' ' . $user->last_name
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        Payment::insert([
            'user_id' => $request->user_id,
            'stripe_cus_id' => $response->id,
            'last_digits' => $request->last_four,
            'brand' => $request->brand,
            'country' => $request->country,
            'expiry' => $request->expiry,
            'funding' => $request->funding,
            'selected' => $request->selected,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return array('msg' => 'Card successfully added');
    }

    public function create_charge() {
        $this->load_stripe();

        try {
            $response = $this->stripe->charges->create([
                'amount' => 300,
                'currency' => 'usd',
                'customer' => 'cus_IA3BQYqAsBbuI5s'
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $response;
    }

    public function get_cards($user_id) {

        $user = User::find($user_id);
        $user->cards;

        return $user;
    }

    public function select_card(Request $request)
    {
        $old_card = Payment::where(
            [
                ['user_id', $request->user_id],
                ['selected', 1]
            ]
        )->firstOrFail();

        $old_card->selected = 0;
        $old_card->save();

        $card = Payment::where(
            [
                ['user_id', $request->user_id],
                ['stripe_cus_id', $request->stripe_id]
            ]
        )->firstOrFail();

        $card->selected = 1;
        $card->save();

        return array('msg' => 'Card successfully selected');
    }

    public function remove_card(Request $request)
    {
        $card = Payment::where(
            [
                ['user_id', $request->user_id],
                ['stripe_cus_id', $request->stripe_id]
            ]
        )->firstOrFail();

        $card->delete();

        return array('msg' => 'Card successfully removed');
    }
    
}
