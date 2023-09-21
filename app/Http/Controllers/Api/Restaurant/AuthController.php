<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Mail\sendMail;
use App\Models\Restaurant;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:restaurants|email:rfc,dns',
            'phone' => 'required|unique:restaurants',
            'password' => 'required|confirmed|min:8',
            'region_id' => 'required',
            'image' => 'required',
            'shipping_taxes' => 'required'
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()){
            return $this->respond(
                '501',
                'Error check your data',
                $validation->messages()
            );
        }
        $password = Hash::make($request->input('password'));
        $request->merge(['password'=> $password]);
        $restaurant = Restaurant::create($request->all());
        $token = $restaurant->createToken('token')->plainTextToken;
        if ($restaurant)
            return $this->respond(
                '200',
                'Registered Successfully',
                $restaurant,
                $token
            );
        return $this->respond('501', 'Error check your data');
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email:rfc,dns|exists:restaurants',
            'password' => 'required',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()){
            return $this->respond(
                '501',
                'Error check your data',
                $validation->messages()
            );
        }

        $restaurant      = Restaurant::where('email', $request->email)->first();
        $restaurantPass  = Hash::check($request->password, $restaurant->password);
        $token = $restaurant->createToken('token')->plainTextToken;
        if ($restaurant && $restaurantPass)
            return $this->respond('200', 'Login Success', $restaurant, $token);
        return $this->respond('501', 'Error Check Your Data');
    }

    public function profile(Request $request)
    {
        # not working as expected
        auth()->user()->update($request->all());
        return auth()->user()->load('region.city')->makeHidden('password');
    }

    public function sendPinCodeInMail($email, $pinCode)
    {
        $details = [
            'title' => 'Your PinCode is Ready',
            'body' => 'It\'s just an email to provide you with your pin_code '. $pinCode
        ];
        \Mail::to($email)->send(new sendMail($details));
    }

    public function resetPassword(Request $request){
        $validate = validator()->make($request->all(), [ 'email' => 'required']);
        if ($validate->fails())
            return response()->json($validate->errors());

        $restaurantData = Restaurant::where('email', '=', $request->email)->first();
        if ($restaurantData && $restaurantData->pin_code === null) {
            $pinCode = rand(100000, 1000000);
            $restaurant = Restaurant::where('email', $request->email)->update(['pin_code' => $pinCode]);
            $this->sendPinCodeInMail($restaurantData->email, $pinCode);

            if ($restaurant)
                return response()->json('Your pin code is ready check your email!');
        }
        return response()->json('Error - Check your email/inbox');
    }

    public function createNewPassword(Request $request){
        $validator = validator()->make($request->all(), [
            'email' => 'required|email:rfc,dns|exists:restaurants',
            'pin_code' => 'required|integer',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails())
            return $this->respond('503', 'Validation Errors', $validator->errors());
        $password = Hash::make($request->password);

        # Ensure this user is registered and if so update his credentials.
        $restaurantPinCode = Restaurant::where('email', $request->email)
            ->where('pin_code', $request->pin_code)
            ->update(['password'=> $password, 'pin_code' => null]);
        if ($restaurantPinCode) {
            return $this->respond('200', 'Your Password has been updated successfully');
        }else{
            return $this->respond('502', 'Incorrect Data');
        }
    }

}
