<?php

namespace App\Http\Requests\Client;

use App\Http\Traits\ApiResponse;
use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class RegisterRequest extends FormRequest
{
    use ApiResponse;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:clients|email:rfc,dns',
            'phone' => 'required|unique:clients',
            'password' => 'required|confirmed|min:8',
            'region_id' => 'required',
            'device_token' => 'required'
        ];
    }

    public function registerClient()
    {
        $password = Hash::make($this->password);
        $this->merge(['password'=> $password]);
        $client = Client::create($this->all());
        $token = $client->createToken('token')->plainTextToken;
        if ($client)
            return $this->respond(
                '200',
                'Registered Successfully',
                $client->toArray(),
                $token
            );
        return $this->respond('501', 'Error check your data');
    }

}
