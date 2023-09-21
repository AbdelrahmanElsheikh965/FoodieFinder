<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponse;
    public function newOrders()
    {
        $orders = auth()->user()->orders()->where('state', 'pending')->get();
        if ($orders)
            return $this->respond('200', 'Done', $orders);
        return $this->respond('404', 'Error No Data');
    }

    public function currentOrders()
    {
        $orders = auth()->user()->orders()->where('state', 'accepted')->get();
        if ($orders)
            return $this->respond('200', 'Done', $orders);
        return $this->respond('404', 'Error No Data');
    }

    public function pastOrders()
    {
        $orders = auth()->user()->orders()->where(function ($query){
            $query->where('state', 'delivered')
                ->orWhere('state', 'declined');
        })->get();
        if ($orders)
            return $this->respond('200', 'Done', $orders);
        return $this->respond('404', 'Error No Data');
    }

    public function accept($id)
    {
        $result = auth()->user()->orders()->where('id', $id)->update(['state' => 'accepted']);
        if ($result)
            return $this->respond('200', 'Updated | Accepted');
        return $this->respond('503', 'Error');
    }

    public function reject($id)
    {
        $result = auth()->user()->orders()->where('id', $id)->update(['state' => 'rejected']);
        if ($result)
            return $this->respond('200', 'Updated | rejected');
        return $this->respond('503', 'Error');
    }

    public function commission()
    {
        $result = Setting::first();
        if ($result)
            return $this->respond('200', 'Commission Retrieved Successfully', $result);
        return $this->respond('503', 'Error');
    }
}
