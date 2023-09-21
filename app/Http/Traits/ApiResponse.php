<?php

namespace App\Http\Traits;

trait ApiResponse{

    # This is for formatting json respond containing (status, message, token)
    public function respond($status, $message, $data = [], $token = null)
    {
        return [
            'status'  => $status,
            'message' => $message,
            'data'    => [
                'data'  => $data,
                'token' => $token
            ]
        ];

    }

}
