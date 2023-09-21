<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Meal;
use App\Models\MealOrder;
use App\Models\Notification;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Setting;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    use ApiResponse;

    public function restaurants(Request $request)
    {
        # Filtration & Searching
        $data = Restaurant::where(function ($query) use ($request){
            if ($request->has('name'))
                $query->where('name', 'like', '%' . $request->name .'%');
            if ($request->has('region_id'))
                $query->where('region_id', 'like', '%' . $request->region_id .'%');
        })->paginate(5);

        if ($data)
            return $this->respond("200", "Done", $data->toArray());
        return $this->respond("404", "Error No Data");
    }

    public function oneRestaurant($id)
    {
        $data = Restaurant::find($id);
        if ($data)
            return $this->respond("200", "Done", $data->toArray());
        return $this->respond("404", "Error No Data");

    }

    public function oneRestaurantMeals($id)
    {
        $data = Meal::where('restaurant_id', $id)->get();
        if ($data)
            return $this->respond("200", "Done", $data->toArray());
        return $this->respond("404", "Error No Data");

    }

    public function oneRestaurantReviews($id)
    {
        $data = Review::where('restaurant_id', $id)->get();
        if ($data)
            return $this->respond("200", "Done", $data->toArray());
        return $this->respond("404", "Error No Data");

    }

    public function oneRestaurantInfo($id)
    {
        # We used with() to avoid n+1 query problem.
        $data = Restaurant::with('region.city')->find($id);
        if ($data)
            return $this->respond("200", "Done", $data);
        return $this->respond("404", "Error No Data");
    }

    public function addReview(Request $request)
    {
        $review = auth()->user()->reviews()->create($request->all());
        if ($review)
            return $this->respond("200", "Done. Your review has been saved");
        return $this->respond("404", "Error No Data");
    }

    public function sendFCM($tokens, $title, $body){
        $data = [
            "registration_ids" => $tokens,
            "notification" => [
                "title" => $title,
                "body" => $body,
                'sound' => "default",
                'color' => "#203E78",
                'light' => 'default'
            ]
        ];

        $dataString = json_encode($data);
        $headers = array(
            'Authorization: key=' . config('fcm.app_key'),
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $result = curl_exec($ch);  // dd();
        curl_close($ch);
        return $result;
    }

    public function createOrder(Request $request)
    {
        $commission = Setting::first()->commission;

        $request->merge(['commission' => $commission]);

        $order = auth()->user()->orders()
                    ->create($request->only(['payment','restaurant_id' ,'commission']));

        $restaurant = Restaurant::find($request->restaurant_id);
        $edit = $order->update(['shipping_taxes' => $restaurant->shipping_taxes]);

        $total = 0;

        foreach ($request->meals as $i => $meal){
            $mealObject = Meal::find($meal['meal_id']);
            $mealOrder = new MealOrder;
            $mealOrder->meal_id     = $meal['meal_id'];
            $mealOrder->order_id    = $order->id;
            $mealOrder->quantity    = $meal['quantity'];
            $mealOrder->notes       = $meal['notes'];
            $mealOrder->price       = ($mealObject->offer_price) ?? $mealObject->price;
            $mealOrder->save();
            $total += $mealOrder->price * $meal['quantity'];
        }
        $commissionAmount = $total * $commission;
        $finalOrderPrice = $total + $commissionAmount + $restaurant->shipping_taxes;
        $result = $order->update(['price' => $finalOrderPrice, 'commission' => $commissionAmount]);

        $notification = Notification::create([
            'notifiable_id' => auth()->user()->id,
            'notifiable_type' => 'App\Models\Client',
            'content' => 'Your Order has been created right now',
            'device_token' => auth()->user()->device_token,
            'order_id' => $order->id

        ]);

        $sent = $this->sendFCM((array)auth()->user()->device_token, 'Alert', 'Your Order has been created right now');

        if ($result && $notification && $sent)
            return $this->respond("200", "Your order has been saved");
        return $this->respond("503", "Error");

    }

}





















