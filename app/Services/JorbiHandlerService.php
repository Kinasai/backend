<?php

namespace App\Services;

use Carbon\Carbon;
use Laravel\Sanctum\PersonalAccessToken;

class JorbiHandlerService
{
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function route($route): \Illuminate\Http\JsonResponse
    {
        return match($route) {
            'game-start' => $this->handleLogin(),
            'send-cu' => $this->handleSendCU(),
            default => $this->handleDefault()
        };
    }
    protected function handleLogin(): \Illuminate\Http\JsonResponse
    {
        /**
         * 'Code' => 'BL|GS',
         * 'TID' => '30.06.2026 19:17:341935',
         * 'MemberID' => 0,
         * 'Token' => 'B97LzPilCosfEOLDB7DFlPIZzVfYH5LKhwCEhVM646626656',
         * 'IP' => '192.168.52.1',
         * 'RefreshToken' => NULL,
         * 'TokenType' => NULL,
         * 'LoginType' => 'DEV',
         * 'AliveKey' => NULL,
         *
         * response
         * MemberID
         * ErrCode
         * ErrMsg
         * ?PCB_ID
         *
         * BNEAResponse.id
         */
        info($this->request);
//        $token = PersonalAccessToken::findToken($this->request['Token']);
//        if ($token) {
            //$account = $token->tokenable;

            $account_data = [
            "MemberID" => 1, //USN
            "PCB_ID" => "PCB123456789",
            "BNEAResponse" => [
                "id" => 1
            ]
            ];
//        ];
            return (new BuildAnswerService('BL|GS'))->success([], $account_data);
//        }
        //return (new BuildAnswerService('BL|GS'))->error('Not found');
    }
    protected function handleLoginSteam(): \Illuminate\Http\JsonResponse
    {
        /**
         * "Code": "BL|GS.STEAM",
         * "TID": packet.TID,
         * "MemberID": 0,
         * "SteamUserTicket": SteamUserTicket,
         * "IP": IP,
         * "TokenType": TokenType,
         * "AliveKey": AliveKey,
         *
         * response
         * MemberID
         * ErrCode
         * ErrMsg
         * Token
         * PCB_ID
         *
         * BNEAResponse.hela_steam_new_member_url
         *
         */
        info($this->request);
//        $token = PersonalAccessToken::findToken($this->request['Token']);
//        if ($token) {
//            $account = $token->tokenable;
//            $account_data = [
//                "MemberID" => 123456789,
//                "Token" => "eyJhbGciOiJIUzI1NiIs...",
//                "PCB_ID" => "PCB123456789",
//                "BNEAResponse" => [
//                      "hela_steam_new_member_url" => "https://example.com/newmember"
//                ]
//            ];
//            return (new BuildAnswerService('BL|GS'))->success([], $account_data);
//        }
        return (new BuildAnswerService('BL|GS.STEAM'))->error('Not found');
    }
    protected function handleSendCU(): \Illuminate\Http\JsonResponse
    {
        sleep(5);
        return (new BuildAnswerService('BL|CU'))->success([], ['AdmTID' => $this->request['TID']]);
    }
    protected function handleDefault(): \Illuminate\Http\JsonResponse
    {
        return (new BuildAnswerService($this->request['Code']))->error('Backend Error: handleDefault');
    }


}
