<?php

namespace App\Http\Requests\Client;

use App\Http\Traits\ApiResponse;
use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Validator;

class LoginRequest extends FormRequest
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
            'email' => 'required|email:rfc,dns|exists:clients',
            'password' => 'required'
        ];
    }

    public function loginClient()
    {
        $validation = Validator::make($this->all(), $this->rules());
        if ($validation->fails()){
            return $this->respond(
                '501',
                'Error check your data',
                $validation->messages()
            );
        }

        $client      = Client::where('email', $this->email)->first();
        $clientPass  = Hash::check($this->password, $client->password);
        $token = $client->createToken('token')->plainTextToken;
        if ($client && $clientPass)
            return $this->respond('200', 'Login Success', $client, $token);
        return $this->respond('501', 'Error Check Your Data');
    }
}
