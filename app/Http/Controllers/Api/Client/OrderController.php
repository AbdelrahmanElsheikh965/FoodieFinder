<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponse;
    public function currentOrders()
    {
        $orders = auth()->user()->orders()->where('state', 'accepted')->get();
        if ($orders)
            return $this->respond('200', 'Done', $orders);
        return $this->respond('404', 'Error No Data');
    }

    public function pastOrders()
    {
        $orders = auth()->user()->orders()->where('state', 'delivered')->get();
        if ($orders)
            return $this->respond('200', 'Done', $orders);
        return $this->respond('404', 'Error No Data');
    }

    public function deliver(Request $request)
    {
//        $result = auth()->user()->orders()->where('id', $id)->update(['state' => 'delivered']);
        $result = Order::where('id', '=',$request->id)
                            ->where('client_id', '=',$request->client_id)
                            ->update(['state' => 'delivered']);
        if ($result)
            return $this->respond('200', 'Updated | Delivered');
        return $this->respond('503', 'Error');
    }

    public function decline($id)
    {
        $result = auth()->user()->orders()->where('id', $id)->update(['state' => 'declined']);
        if ($result)
            return $this->respond('200', 'Updated | Declined');
        return $this->respond('503', 'Error');
    }

    public function clientNotifications()
    {
        # search for [morph map]
        $result = auth()->user()->notifications()->paginate(6);

        if ($result)
            return $this->respond('200', 'Done', $result);
        return $this->respond('503', 'Error');
    }

    public function readClientNotifications(Request $request)
    {
        $result = Notification::where('id', $request->id)->update(['is_seen' => 1]);

        if ($result)
            return $this->respond('200', 'Done', $result);
        return $this->respond('503', 'Error');
    }

}
