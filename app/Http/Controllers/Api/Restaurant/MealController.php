<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Meal;
use Validator;
use Illuminate\Http\Request;

class MealController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $records = Meal::paginate(4);
        return $this->respond('200', 'Retrieved Successfully', $records);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), ['*' => 'required']);
        if ($validation->fails()){
            return $this->respond(
                '501',
                'Error check your data',
                $validation->messages()
            );
        }
        $meal = auth('sanctum')->user()->meals()->create($request->all());
        if ($meal)
            return $this->respond(
                '200',
                'Registered Successfully',
                $meal
            );
        return $this->respond('501', 'Error check your data');
    }

    public function show($id)
    {
        $meal = Meal::find($id);
        if ($meal)
            return $this->respond(
                '200',
                'Retrieved Successfully',
                $meal
            );
        return $this->respond('404', 'Error check your data');
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), ['*' => 'required']);
        if ($validation->fails()){
            return $this->respond(
                '501',
                'Error check your data',
                $validation->messages()
            );
        }
        $meal = Meal::find($id);
        $meal->fill($request->all());
        if ($meal->save())
            return $this->respond(
                '200',
                'Updated Successfully',
                $meal
            );
        return $this->respond('501', 'Error check your data');
    }

    public function destroy($id)
    {
        $meal = Meal::findOrFail($id);
        if ($meal->delete())
            return $this->respond('200', 'deleted');
        return $this->respond('404', 'Error');
    }
}
