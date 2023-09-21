<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Meal;
use Validator;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $records = Offer::paginate(4);
        return $this->respond('200', 'Retrieved Successfully', $records);
    }


    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), ['*' => 'required']);
        if ($validation->fails()){
            return $this->respond('501','Error check your data',$validation->messages());
        }
        $offer = auth('sanctum')->user()->offers()->create($request->all());
        if ($offer)
            return $this->respond(
                '200',
                'Registered Successfully',
                $offer
            );
        return $this->respond('501', 'Error check your data');
    }

    public function show($id)
    {
        $validate = Validator::make(['id' => $id], ['id' => 'exists:offers']);
        if ($validate->fails())
            return $this->respond('404', 'Not found');
        $offer = Offer::find($id);
        if ($offer)
            return $this->respond(
                '200',
                'Retrieved Successfully',
                $offer
            );
        return $this->respond('404', 'Error check your data');
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make(
            [
                'id' => $id,
                'request' => $request->all()
            ],
            [
                'id' => 'exists:offers',
                'request.*' => 'required'
            ]);
        if ($validation->fails()){
            return $this->respond(
                '501',
                'Error check your data',
                $validation->messages()
            );
        }
        $offer = Offer::find($id);
        $offer->fill($request->all());
        if ($offer->save())
            return $this->respond(
                '200',
                'Updated Successfully',
                $offer
            );
        return $this->respond('501', 'Error check your data');
    }

    public function destroy($id)
    {
        $validate = Validator::make(['id' => $id], ['id' => 'exists:offers']);
        if ($validate->fails())
            return $this->respond('404', 'Not found');
        $offer = Offer::findOrFail($id);
        if ($offer->delete())
            return $this->respond('200', 'deleted');
        return $this->respond('404', 'Error');
    }
}
