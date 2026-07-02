<?php

namespace App\Services;

use App\Models\ServerStatus;

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
            'game-start-steam' => $this->handleLoginSteam(),
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
//        $token = PersonalAccessToken::findToken($this->request['Token']);
//        if ($token) {
            //$account = $token->tokenable;

            $account_data = [
            "MemberID" => 1, //USN
            "PCB_ID" => ""  //PC club
            ];
            $bnea_response = [
                "id" => 1,
            ];
//        ];
            return (new BuildAnswerService('BL|GS'))->success($bnea_response, $account_data);
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
//        $token = PersonalAccessToken::findToken($this->request['Token']);
//        if ($token) {
//            $account = $token->tokenable;
            $account_data = [
                "MemberID" => 1, //USN
                "Token" => "dummy_token_123",
                "PCB_ID" => "", //PC club
            ];
            $bnea_response = [
                "hela_steam_new_member_url" => "",
            ];
            return (new BuildAnswerService('BL|GS.STEAM'))->success($bnea_response, $account_data);
//        }
//        return (new BuildAnswerService('BL|GS.STEAM'))->error('Not found');
    }
    protected function handleSendCU(): \Illuminate\Http\JsonResponse
    {
        if (isset($this->request['CHID'])) {
            ServerStatus::query()->updateOrCreate(
                ['server_id' => $this->request['CHID']],
                [
                    'online_users' => $this->request['CU'] ?? 0,
                    'wait_users'   => $this->request['WAITCU'] ?? 0,
                    'lobby_users'  => $this->request['LOBBYCU'] ?? 0,
                    'status'       => $this->request['Status'] ?? 0,
                    'congestion'   => $this->request['Congestion'] ?? 0,
                    'channel_data' => $this->request['ChannelCU'] ?? null,
                ]
            );
        }

        return (new BuildAnswerService('BL|CU.ACK'))->success(['id' => 0]);
    }
    protected function handleDefault(): \Illuminate\Http\JsonResponse
    {
        return (new BuildAnswerService($this->request['Code']))->error('Backend Error: handleDefault');
    }


}
