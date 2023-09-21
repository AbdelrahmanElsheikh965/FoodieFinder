<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\ContactUs;
use App\Models\Offer;
use App\Models\Setting;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    use ApiResponse;

    public function contactUs(Request $request)
    {
        $addData = ContactUs::create($request->all());
        if ($addData)
            return $this->respond("200", "Your data has been sent");
        return $this->respond("503", "Error");
    }

    public function settings()
    {
        $data = Setting::all();
        if ($data)
            return $this->respond("200", "Done", $data);
        return $this->respond("503", "Error");
    }

    public function offers()
    {
        $data = Offer::all();
        if ($data)
            return $this->respond("200", "Done", $data);
        return $this->respond("503", "Error");
    }
}
