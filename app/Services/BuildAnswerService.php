<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class BuildAnswerService
{
    protected $code;
    public function __construct($code)
    {
        $this->code = $code;
    }

    public function success(array $bneaResponse = [], array $data = []): \Illuminate\Http\JsonResponse
    {
        $response = array_merge([
            'Code'    => $this->code,
            'ErrCode' => 1000,
            'ErrMsg'  => 'OK',
        ], $data);

        if ($bneaResponse) {
            $response['BNEAResponse'] = $bneaResponse;
        }

        return response()->json($response);
    }
    public function error($error = null): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'Code' => $this->code,
            'ErrCode' => -1000,
            'ErrMsg' => $error ?? 'Error',
        ]);
    }



}
