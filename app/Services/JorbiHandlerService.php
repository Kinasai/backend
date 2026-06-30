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
         * "Code": "BL|GS",
         * "TID": packet.TID,
         * "MemberID": 0,
         * "Token": Token,
         * "IP": IP,
         * "RefreshToken": RefreshToken,
         * "TokenType": TokenType,
         * "LoginType": LoginType,
         * "AliveKey": AliveKey,
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
//            $account = $token->tokenable;
//        $account_data = [
//            "MemberID" => 123456789, //USN
//            "PCB_ID" => "PCB123456789",
//            "BNEAResponse" => [
//                "id" => 987654321
//            ]
//        ];
//            return (new BuildAnswerService('BL|GS'))->success([], $account_data);
//        }
        return (new BuildAnswerService('BL|GS'))->error('Not found');
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
        info($this->request);
        $now = Carbon::now()->addSeconds(10);
        $date = $now->format('d.m.Y H:i:s') . substr($now->format('v'), 0, 2);
        return (new BuildAnswerService('BL|CU'))->success([], ['AdmTID' => $date]);
    }
    protected function handleDefault(): \Illuminate\Http\JsonResponse
    {
        return (new BuildAnswerService($this->request['Code']))->error('Backend Error: handleDefault');
    }


}
