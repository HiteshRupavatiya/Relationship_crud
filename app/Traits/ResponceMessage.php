<?php

namespace App\Traits;

trait ResponceMessage
{
    public function ErrorResponse($validateData)
    {
        return response()->json([
            'status'  => 403,
            'message' => 'validation error',
            'errors'  => $validateData->errors()
        ], 403);
    }

    public function DataNotFound()
    {
        return response()->json([
            'status'  => 401,
            'message' => 'Data Not Found'
        ], 401);
    }

    public function Success($message, $data = "")
    {
        return response()->json([
            'status'  => 200,
            'success' => $message,
            'data'    => $data
        ]);
    }
}
