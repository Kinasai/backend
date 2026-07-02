<?php

namespace App\Services;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\TagCollection;
use App\Models\Category;
use App\Models\ServerStatus;
use App\Models\Tag;
use stdClass;

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
            'sso-token' => $this->handleSsoToken(),
            'categories' => $this->handleCategories(),
            'tags' => $this->handleTags(),
            'send-cu' => $this->handleSendCU(),
            'send-op' => $this->handleSendOP(),
            'cash' => $this->handleCash(),
            'items' => $this->handleItems(),
            'account' => $this->handleAccount(),
            'account-premium' => $this->handleAccountPremium(),
            'account-mileage' => $this->handleAccountMileage(),
            'account-inventory-injected' => $this->handleAccountInventoryInjected(),
            'account-xbox-inventory' => $this->handleAccountXboxInventory(),
            'who' => $this->handleWho(),
            'vip' => $this->handleVip(),
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
    protected function handleAccountMileage(): \Illuminate\Http\JsonResponse
    {
        /**
         * {
         * Code: 'BL|ACCOUNT.MILEAGE',
         * TID: '02.07.2026 15:55:501346',
         * MemberID: 1
         * }
         *
         * response
         * ErrCode
         * ErrMsg
         * BNEAResponse
         */
        $bnea_response = [
            'data' => [
                'total_mileage' => 5000
            ]
        ];
        return (new BuildAnswerService('BL|ACCOUNT.MILEAGE'))->success($bnea_response, ["TID" => $this->request['TID']]);
    }
    protected function handleCash(): \Illuminate\Http\JsonResponse
    {
        /**
         * Code: 'BL|CASH',
         * TID: '02.07.2026 15:55:501346',
         * MemberID: 1
         */
        return (new BuildAnswerService('BL|CASH'))->success([], ["Balance" => 123456, "BNEAResponse" => [], "TID" => $this->request['TID']]);
    }
    protected function handleAccountInventoryInjected(): \Illuminate\Http\JsonResponse
    {
        /**
         * {
         * Code: 'BL|ACCOUNT.INVENTORY.INJECTED',
         * TID: '02.07.2026 17:07:3792',
         * MemberID: 1
         * }
         */
        return (new BuildAnswerService('BL|ACCOUNT.INVENTORY.INJECTED'))->success([], ["BNEAResponse" => [], "TID" => $this->request['TID']]);
    }
    protected function handleAccountXboxInventory(): \Illuminate\Http\JsonResponse
    {
        /**
         * {
         * Code: 'BL|ACCOUNT.XBOXINVENTORY',
         * TID: '02.07.2026 17:07:3791',
         * MemberID: 1,
         * Market: ''
         * }
         */
        return (new BuildAnswerService('BL|ACCOUNT.XBOXINVENTORY'))->success([], ["BNEAResponse" => [], "TID" => $this->request['TID']]);
    }
    protected function handleAccountPremium(): \Illuminate\Http\JsonResponse
    {
        /**
         * {
         * Code: 'BL|ACCOUNT.PREMIUM',
         * TID: '02.07.2026 17:07:0448',
         * MemberID: 1
         * }
         */
        return (new BuildAnswerService('BL|ACCOUNT.PREMIUM'))->success([], ["BNEAResponse" => [], "TID" => $this->request['TID']]);
    }
    protected function handleVip(): \Illuminate\Http\JsonResponse
    {
        /**
         * { Code: 'BL|VIP', TID: '02.07.2026 17:07:3388', MemberID: 1 }
         */
        return (new BuildAnswerService('BL|VIP'))->success([], ["BNEAResponse" => [], "TID" => $this->request['TID']]);
    }
    protected function handleWho(): \Illuminate\Http\JsonResponse
    {
        /**
         * { Code: 'BL|VIP', TID: '02.07.2026 17:07:3388', MemberID: 1 }
         */
        return (new BuildAnswerService('BL|WHO'))->success([], ["BNEAResponse" => [], "TID" => $this->request['TID']]);
    }
    protected function handleItems(): \Illuminate\Http\JsonResponse
    {
        /**
         * Code: 'BL|ITEMS',
         * TID: '02.07.2026 15:55:501346',
         * MemberID: 1
         */
        $response = [
            "code" => 0, // КРИТИЧНО: Должен быть 0, иначе клиент выдаст ошибку CashShop Error
            "message" => "OK",
            "data" => [
                "page" => 1,
                "page_total" => 1,
                "bundle_count" => 1,
                "product_code" => "BLESS",
                "product_name" => "Bless Unleashed",
                "bundles" => [
                    [
                        "item_process_type" => 2,
                        "item_options" => new stdClass(), // Пустой объект {}
//                        'item_options' => [
//                            'purchasable_level' => 1,      // Минимальный уровень для покупки
//                            'purchase_limit_level' => 45,  // Максимальный уровень
//                            'item_margin' => 0
//                        ],
                        "category_name" => "Bundles",
                        "item_type_id" => 2,
                        "price" => 7000,
                        "price_original" => 7000,
                        "ordering_id" => 1,
                        // ФЛАГ: Лимиты на покупку
                        // 'N' - товар можно покупать без ограничений (или по стандартным лимитам).
                        // 'Y' - товар имеет сложную логику лимитов. В этом случае игра
                        //       начинает проверять следующие ТРИ поля (acct_type, period, policy).
                        "limit_flag" => "Y",
                        "acct_type_code" => 2,
                        "limit_period_type_code" => 3, //если limit_flag = 'Y' 1 = Дневной лимит, 2 = Недельный, 3 = Месячный и т.д.
                        "limit_policy_val" => "00", // если limit_flag = 'Y' Значение лимита (например: "5" штук в день)
                        "category_tags" => [],
                        "created_at" => "2026-02-10T10:51:51+00:00",
                        "purchase_limit" => 3,
                        "item_dc_rate" => 0,  // Процент скидки (Discount Rate)
                        "user_purchase_count" => 0,
                        "desc_short" => " ",
                        "category_id" => "AACAAB",
                        "policy_end_date" => "",
                        "updated_at" => "",
                        "policy_start_date" => "",
                        // ФЛАГ: Таймер продаж (count_down_flag)
                        // 'N' - товар продается всегда (таймера нет).
                        // 'Y' - включает таймер распродажи. В этом случае ОБЯЗАТЕЛЬНО
                        //       нужно заполнить поля created_at, sales_start и sales_end!
                        "count_down_flag" => "N",
                        "game_item_id" => "96159",
                        "quantity" => 1,
                        "sales_end" => "2999-12-31T23:59:59+00:00",
                        "item_options_error_msg" => "",
                        "goods_id" => "1636",
                        "tags" => [],
                        "desc_long" => "Effect on Use: Grants an Advanced Constellation Activation Ticket.",
                        "parent_id" => "AAC",
                        "sales_start" => "2026-02-10T00:00:00+00:00",
                        "name" => "Advanced Constellation Activation Ticket Special Pack",
                        "random_category" => "",
                        "region" => "ALL",
                        "thumbnails" => [
                            [
                                "thumbnail_id" => "3602",
                                "thumbnail_category" => "1",
                                "thumbnail_name" => "https://payfile.vlfhela.com/cashshop_constellation_pack.png"
                            ]
                        ]
                    ]
                ]
            ]
        ];
        return (new BuildAnswerService('BL|ITEMS'))->success($response);
    }
    protected function handleSsoToken(): \Illuminate\Http\JsonResponse
    {
        $bnea_response = [
            "data" => "eyJhbGciOiJIUzUxMiJ9.eyJnX3p0IjoiZXlKaGJHY2lPaUpJVXpVeE1pSjkuZXlKa2FYTjBjbWxpZFhSdmNsVnpaWEpKWkNJNklqYzJOVFl4TVRrNE1ERTROREV6TmpjNUlpd2liR0Z1WjNWaFoyVkRaQ0k2Ym5Wc2JDd2ljMlZ6YzJsdmJrdGxlU0k2SWpRME1EQTROVEk2UjBGTlJUb3hJaXdpYVhOU1pXcHZhVzVsWkNJNlptRnNjMlVzSW0xbVlVTmtJam9pVGs5T1JTSXNJbTVsZDNOc1pYUjBaWEpCWTJObGNIUlpiaUk2Ym5Wc2JDd2lhWEFpT2lJNE15NHlNakF1TVRjeElpd2ljSEp2ZG1sa1pYSkRaQ0k2SWtoRlRFRWlMQ0pqYjNWdWRISjVRMlFpT2lKbllpSXNJbk4wWVhSMWMwTmtJam9pVGs5U1RVRk1JaXdpY0d4aGRHWnZjbTB5Ym1SVFpXTjFjbWwwZVVObGNuUlpiaUk2SWs0aUxDSmthWE4wY21saWRYUnZja3h2WjJsdUlqb2lVMVJGUVUwaUxDSndZWE56ZDJSRGFHRnVaMlZFZENJNklpSXNJbVJwYzNSeWFXSjFkRzl5VW1WbmFYTjBaWElpT2lKVFZFVkJUU0lzSW5WemJpSTZJalEwTURBNE5USWlMQ0pzWVhOMFRHOW5hVzVFZENJNklpSXNJbXh2WjJsdVNYQWlPaUl5TGpJMkxqVTBMakV6TlNJc0ltNXBZMnR1WVcxbElqcHVkV3hzTENKeVpXZHBjM1JsY2tSMElqb2lJaXdpYzJWemMybHZibFI1Y0dVaU9pSkhRVTFGSWl3aWEzSkRaWEowV1c0aU9pSlpJaXdpWlcxaGFXd2lPbTUxYkd3c0ltaGhjMmdpT2lJeE5EazVZV1JsWlRnME1UYzBPRFZqT1dJNE1USTJaamcxWVdKbVlUazVaU0lzSW01cFkydHVZVzFsVFc5a2FXWjVRMjUwSWpwdWRXeHNmUS5Gd3dqa1ZsWUY0UEFrMFYzNmF1a05LRVZSMWgzWk12U1pkRkJBRElHVUstWGNGSTF1QlJSUVpoOWc0TlJLNDUxOU5UZldNYV9JMzRwLWg3NmlLSndxZyIsImV4cCI6MTc4MjI5NDU5NH0.jG1PFo_WuIGVK9m5vsvV2IC3x3jBK88CB7N_xkXcvIwdMLx6cHdAYKFWDmQCiw2DUBfReai3mmvU0R1QVwnLDQ",
            'code' => 0,
            'message' => 'OK',
        ];
        return (new BuildAnswerService('BL|SSO.TOKEN'))->success($bnea_response, ["TID" => $this->request['TID']]);
    }
    protected function handleCategories(): \Illuminate\Http\JsonResponse
    {
        $bnea_response = [
            "data" => CategoryCollection::make(
                Category::query()->orderBy('ordering_id')->paginate(20)
            )
        ];
        return (new BuildAnswerService('BL|CATEGORIES'))->success($bnea_response, ["TID" => $this->request['TID']]);
    }
    protected function handleTags(): \Illuminate\Http\JsonResponse
    {
        $bnea_response = [
            "data" => TagCollection::make(
                Tag::query()->orderBy('created_at')->paginate(20)
            )
        ];
        return (new BuildAnswerService('BL|CATEGORIES'))->success($bnea_response, ["TID" => $this->request['TID']]);
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
