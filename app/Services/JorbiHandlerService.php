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
            'product-vip-level' => $this->handleProductVipLevel(),
            'send-cu' => $this->handleSendCU(),
            'send-op' => $this->handleSendOP(),
            'account' => $this->handleAccount(),
            default => $this->handleDefault()
        };
    }
    protected function handleLogin(): \Illuminate\Http\JsonResponse
    {
//        $token = PersonalAccessToken::findToken($this->request['Token']);
//        if ($token) {
            //$account = $token->tokenable;

            $account_data = [
            "MemberID" => 1, //USN
            "PCB_ID" => "",  //PC club
            "TID" => $this->request['TID']
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
         * {
         * Code: 'BL|GS.STEAM',
         * TID: '02.07.2026 14:10:5762',
         * MemberID: 0,
         * SteamUserTicket: '1400000036CFA307FA0FB6C36F44770301001001B342466A18000000010000000200000082DC5D174AED5BAEF23D490A01000000B200000032000000040000006F44770301001001E8221300BC049BB201DDA8C000000000BDC43C6A3D74586A01009EA4060000000000D35AC6457F89816761072C3E8CFE7FF348B0689DD01E135B271D28CE948E3FF44C79AB24CD57F24DC6BA6A207D1F730C67A5F782B655FB1F45ACA4E7C02DFBE4ED3BEEFD0E9DF488605C017C2B44C7AD82310BC806116AF17CE1375D67808D7298EBB37EFDAE679D6A119E1881135977534030ACFD5220214BE3BBD7F304D98F',
         * IP: '192.168.52.1',
         * TokenType: 'Bearer',
         * AliveKey: 'cb3583845bb76c3f7d20cb12e6bae33297f12e4f1412675cb9007ea42e7a307e'
         * }
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

//        $token = PersonalAccessToken::findToken($this->request['AliveKey']);
//        if ($token) {
//            $account = $token->tokenable;
            $account_data = [
                "MemberID" => 1, //USN
                "Token" => "dummy_token_123",
                "PCB_ID" => "", //PC club
                "TID" => $this->request['TID']
            ];
            $bnea_response = [
                "hela_steam_new_member_url" => "",
            ];
            return (new BuildAnswerService('BL|GS.STEAM'))->success($bnea_response, $account_data);
//        }
//        return (new BuildAnswerService('BL|GS.STEAM'))->error('Not found');
    }
    protected function handleProductVipLevel(): \Illuminate\Http\JsonResponse
    {
        /**
         * Code: 'BL|PRODUCT.VIP.LEVEL'
         * TID: '02.07.2026 11:45:205'
         *
         * response
         * ErrCode
         * ErrMsg
         * BNEAResponse
         */
        return (new BuildAnswerService('BL|PRODUCT.VIP.LEVEL'))->success([], ["TID" => $this->request['TID'], 'BNEAResponse' => []]);
    }
    protected function handleAccount(): \Illuminate\Http\JsonResponse
    {
        /**
         * {
         * Code: 'BL|ACCOUNT',
         * TID: '02.07.2026 14:10:5863',
         * MemberID: 1,
         * Token: 'dummy_token_123',
         * TokenType: 'Bearer'
         * }
         *
         * response
         * ErrCode
         * ErrMsg
         * BNEAResponse
         */
        $bnea_response = [
            'data' => [
                'associates' => [
                    'parent' => [
                        'account_id' => '4400852',
                        'updated_at' => '',
                        'created_at' => '',
                        'email' => 'kinasai@ya.ru',
                    ]
                ]
            ]
        ];
        return (new BuildAnswerService('BL|ACCOUNT'))->success($bnea_response, ["TID" => $this->request['TID']]);
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

        return (new BuildAnswerService('BL|CU.ACK'))->success(['id' => 0], ["TID" => $this->request['TID']]);
    }
    protected function handleSendOP(): \Illuminate\Http\JsonResponse
    {
        return (new BuildAnswerService('BL|OP'))->success([], ["TID" => $this?->request['TID'] ?? '']);
    }
    protected function handleDefault(): \Illuminate\Http\JsonResponse
    {
        return (new BuildAnswerService($this->request['Code']))->error('Backend Error: handleDefault');
    }


}
