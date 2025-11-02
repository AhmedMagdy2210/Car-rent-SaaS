<?php

namespace App\Traits;

trait ApiResponse
{
    public function success($message = 'Success', $code = 200, $data = [])
    {
        $response = [
            'success' => true,
            'message' => $message
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }
        return response()->json($response, $code);
    }
    public function error($message = 'Error', $code = 400, $errors = [])
    {
        $response = [
            'success' => false,
            'message' => $message
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }
        return response()->json($response, $code);
    }

}
