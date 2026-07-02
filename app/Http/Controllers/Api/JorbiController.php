<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BuildAnswerService;
use App\Services\JorbiHandlerService;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class JorbiController extends Controller
{
    protected $jorbi_handler;

    public function __construct(Request $request)
    {
        $this->jorbi_handler = new JorbiHandlerService($request->all());
    }

    public function handler(Request $request, $route): \Illuminate\Http\JsonResponse
    {
        $response = $this->jorbi_handler->route($route);
        if (is_array($response) && $request->has('TID')) {
            $response['TID'] = $request->input('TID');
        }
        return $response;
    }
}
