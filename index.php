<?php
define('API_KEY','336347835:AAFrbBzzhLX9xgIizUO_-mAP6kwJRj2ZR78');
//----######------
function makereq($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
$result=json_decode($message,true);
//_
$update = json_decode(file_get_contents('php://input'));
var_dump($update);
//=========
$chat_id = $update->message->chat->id;
$message_id = $update->message->message_id;
$from_id = $update->message->from->id;
$last_name = $update->message->from->last_name;
$frist_name = $update->message->from->first_name;
$username = $update->message->from->username;
$name = $update->message->from->first_name;
$username = $update->message->from->username;
$textmessage = isset($update->message->text)?$update->message->text:'';
$txtmsg = $update->message->text;
$reply = $update->message->reply_to_message->forward_from->id;
$stickerid = $update->message->reply_to_message->sticker->file_id;
$admin = 87691174;
$step = file_get_contents("data/".$from_id."/step.txt");
//-------
function SendMessage($ChatId, $TextMsg)
{
    makereq('sendMessage',[
        'chat_id'=>$ChatId,
        'text'=>$TextMsg,
        'parse_mode'=>"MarkDown"
    ]);
}
function SendSticker($ChatId, $sticker_ID)
{
    makereq('sendSticker',[
        'chat_id'=>$ChatId,
        'sticker'=>$sticker_ID
    ]);
}
function Forward($KojaShe,$AzKoja,$KodomMSG)
{
    makereq('ForwardMessage',[
        'chat_id'=>$KojaShe,
        'from_chat_id'=>$AzKoja,
        'message_id'=>$KodomMSG
    ]);
}
function save($filename,$TXTdata)
{
    $myfile = fopen($filename, "w") or die("Unable to open file!");
    fwrite($myfile, "$TXTdata");
    fclose($myfile);
}
//_________
//===========
if ($step == 'create bot') {
if ($textmessage == '🔙برگشت'){
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"یکی از دکمه های زیر را برای ساخت ربات کلیک کنید",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"ربات XO❌"],['text'=>" ربات کوتاه کننده لینک✈️"]
                ],
                [
                    ['text'=>"ربات چک کردن کد php 🏵"],['text'=>"ربات فال گیر🌀"]
                ],
                [
                    ['text'=>"روبات صلوات شمار📿"],['text'=>"ربات ماشین حساب📲"]
                ],
                [
                    ['text'=>"ربات گت اینفوℹ️"],['text'=>"ربات ساخت پیام مخفی📪"]
                ],
                [
                    ['text'=>"ربات @Bold 🔘"],['text'=>"ربات اینستا دانلود📥"]
                ],
                [
                    ['text'=>"ربات ادیت موزیک🔧"],['text'=>"ربات سین ساز👁‍🗨"]
                ],
                [
                    ['text'=>"🔙منوی اصلی"]
                ],
            ],
            'resize_keyboard'=>true
        ])
    ]));
    save("data/$from_id/step.txt", "none");
}else {
    $token = $textmessage;

    $userbot = json_decode(file_get_contents('https://api.telegram.org/bot' . $token . '/getme'));
    //==================
    function objectToArrays($object)
    {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        return array_map("objectToArrays", $object);
    }

    $resultb = objectToArrays($userbot);
    $un = $resultb["result"]["username"];
    $ok = $resultb["ok"];
    if ($ok != 1) {
        //Token Not True
        SendMessage($chat_id, "توکن نا معتبر!\nYour token is invalid");
    } else {
        SendMessage($chat_id, "در حال ساخت ربات ...\n");
        if (file_exists("bots/$un/index.php")) {
            $source = file_get_contents("bot/index1.php");
            $source = str_replace("**TOKEN**", $token, $source);
            $source = str_replace("**ADMIN**", $from_id, $source);
            save("bots/$un/index.php", $source);
            file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

            var_dump(makereq('sendMessage', [
                'chat_id' => $update->message->chat->id,
                'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                'parse_mode' => 'MarkDown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                        ]

                    ],
                    'resize_keyboard' => true
                ])
            ]));
        } else {
            save("data/$from_id/tedad.txt", "1");
            save("data/$from_id/step.txt", "none");
            save("data/$from_id/bots.txt", "$un");

            mkdir("bots/$un");
            mkdir("bots/$un/data");

            $source = file_get_contents("bot/index1.php");
            $source = str_replace("**TOKEN**", $token, $source);
            $source = str_replace("**ADMIN**", $from_id, $source);
            save("bots/$un/index.php", $source);
            file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

            var_dump(makereq('sendMessage', [
                'chat_id' => $update->message->chat->id,
                'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                'parse_mode' => 'MarkDown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                        ]

                    ],
                    'resize_keyboard' => true
                ])
            ]));
        }
    }
}
}
elseif ($step == 'create bot2') {
if ($textmessage == '🔙برگشت'){
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"یکی از دکمه های زیر را برای ساخت ربات کلیک کنید",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"ساخت ربات XO❌"],['text'=>"ساخت ربات کوتاه کننده لینک✈️"]
                ],
                [
                    ['text'=>"ساخت ربات چک کردن کد php 🏵"],['text'=>"ساخت ربات فال گیر🌀"]
                ],
                [
                    ['text'=>"ساخت روبات صلوات شمار📿"],['text'=>"ساخت ربات ماشین حساب📲"]
                ],
                [
                    ['text'=>"ساخت ربات گت اینفوℹ️"],['text'=>"ساخت ربات ساخت پیام مخفی📪"]
                ],
                [
                    ['text'=>"ساخت ربات @Bold 🔘"],['text'=>"ساخت ربات اینستا دانلود📥"]
                ],
                [
                    ['text'=>"ساخت ربات ادیت موزیک🔧"],['text'=>"ساخت ربات سین ساز👁‍🗨"]
                ],
                [
                    ['text'=>"🔙منوی اصلی"]
                ],
            ],
            'resize_keyboard'=>true
        ])
    ]));
    save("data/$from_id/step.txt", "none");
}else {
    $token = $textmessage;

    $userbot = json_decode(file_get_contents('https://api.telegram.org/bot' . $token . '/getme'));
    //==================
    function objectToArrays($object)
    {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        return array_map("objectToArrays", $object);
    }

    $resultb = objectToArrays($userbot);
    $un = $resultb["result"]["username"];
    $ok = $resultb["ok"];
    if ($ok != 1) {
        //Token Not True
        SendMessage($chat_id, " توکن نا متعبر ");
    } else {
        SendMessage($chat_id, "در حال ساخت ربات ...\n ");
        if (file_exists("bots/$un/index.php")) {
            $source = file_get_contents("bot/index3.php");
            $source = str_replace("**TOKEN**", $token, $source);
            $source = str_replace("**ADMIN**", $from_id, $source);
            save("bots/$un/index.php", $source);
            file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

            var_dump(makereq('sendMessage', [
                'chat_id' => $update->message->chat->id,
                'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                'parse_mode' => 'MarkDown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                        ]

                    ],
                    'resize_keyboard' => true
                ])
            ]));
        } else {
            save("data/$from_id/tedad.txt", "1");
            save("data/$from_id/step.txt", "none");
            save("data/$from_id/bots.txt", "$un");

            mkdir("bots/$un");

            $source = file_get_contents("bot/index3.php");
            $source = str_replace("**TOKEN**", $token, $source);
            $source = str_replace("**ADMIN**", $from_id, $source);
            save("bots/$un/index.php", $source);
            file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

            var_dump(makereq('sendMessage', [
                'chat_id' => $update->message->chat->id,
                'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                'parse_mode' => 'MarkDown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                        ]

                    ],
                    'resize_keyboard' => true
                ])
            ]));
        }
    }
}
}

elseif ($step == 'create bot3') {
    if ($textmessage == '🔙برگشت'){
        var_dump(makereq('sendMessage',[
            'chat_id'=>$update->message->chat->id,
            'text'=>"یکی از دکمه های زیر را برای ساخت ربات کلیک کنید",
            'parse_mode'=>'MarkDown',
            'reply_markup'=>json_encode([
                'keyboard'=>[
                    [
                        ['text'=>"ساخت ربات XO❌"],['text'=>"ساخت ربات کوتاه کننده لینک✈️"]
                    ],
                    [
                        ['text'=>"ساخت ربات چک کردن کد php 🏵"],['text'=>"ساخت ربات فال گیر🌀"]
                    ],
                    [
                        ['text'=>"ساخت روبات صلوات شمار📿"],['text'=>"ساخت ربات ماشین حساب📲"]
                    ],
                    [
                        ['text'=>"ساخت ربات گت اینفوℹ️"],['text'=>"ساخت ربات ساخت پیام مخفی📪"]
                    ],
                    [
                        ['text'=>"ساخت ربات @Bold 🔘"],['text'=>"ساخت ربات اینستا دانلود📥"]
                    ],
                    [
                        ['text'=>"ساخت ربات ادیت موزیک🔧"],['text'=>"ساخت ربات سین ساز👁‍🗨"]
                    ],
                    [
                        ['text'=>"🔙منوی اصلی"]
                    ],
                ],
                'resize_keyboard'=>true
            ])
        ]));
        save("data/$from_id/step.txt", "none");
    }else{
        $token = $textmessage;

        $userbot = json_decode(file_get_contents('https://api.telegram.org/bot' . $token . '/getme'));
        //==================
        function objectToArrays($object)
        {
            if (!is_object($object) && !is_array($object)) {
                return $object;
            }
            if (is_object($object)) {
                $object = get_object_vars($object);
            }
            return array_map("objectToArrays", $object);
        }

        $resultb = objectToArrays($userbot);
        $un = $resultb["result"]["username"];
        $ok = $resultb["ok"];
        if ($ok != 1) {
            //Token Not True
            SendMessage($chat_id, "توکن نا معتبر!\nYour token is invalid");
        } else {
            SendMessage($chat_id, "در حال ساخت ربات ...\n ");
            if (file_exists("bots/$un/index.php")) {
                $source = file_get_contents("bot/index9.php");
                $source = str_replace("**TOKEN**", $token, $source);
                $source = str_replace("**ADMIN**", $from_id, $source);
                save("bots/$un/index.php", $source);
                file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

                var_dump(makereq('sendMessage', [
                    'chat_id' => $update->message->chat->id,
                    'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                    'parse_mode' => 'MarkDown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                            ]

                        ],
                        'resize_keyboard' => true
                    ])
                ]));
            } else {
                save("data/$from_id/tedad.txt", "1");
                save("data/$from_id/step.txt", "none");
                save("data/$from_id/bots.txt", "$un");

                mkdir("bots/$un");
                mkdir("bots/$un/data");

                $source = file_get_contents("bot/index9.php");
                $source = str_replace("**TOKEN**", $token, $source);
                $source = str_replace("**ADMIN**", $from_id, $source);
                save("bots/$un/index.php", $source);
                file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

                var_dump(makereq('sendMessage', [
                    'chat_id' => $update->message->chat->id,
                    'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                    'parse_mode' => 'MarkDown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                            ]

                        ],
                        'resize_keyboard' => true
                    ])
                ]));
            }
        }
    }
}
elseif ($step == 'create bot4') {
if ($textmessage == '🔙برگشت'){
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"یکی از دکمه های زیر را برای ساخت ربات کلیک کنید",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"ساخت ربات XO❌"],['text'=>"ساخت ربات کوتاه کننده لینک✈️"]
                ],
                [
                    ['text'=>"ساخت ربات چک کردن کد php 🏵"],['text'=>"ساخت ربات فال گیر🌀"]
                ],
                [
                    ['text'=>"ساخت روبات صلوات شمار📿"],['text'=>"ساخت ربات ماشین حساب📲"]
                ],
                [
                    ['text'=>"ساخت ربات گت اینفوℹ️"],['text'=>"ساخت ربات ساخت پیام مخفی📪"]
                ],
                [
                    ['text'=>"ساخت ربات @Bold 🔘"],['text'=>"ساخت ربات اینستا دانلود📥"]
                ],
                [
                    ['text'=>"ساخت ربات ادیت موزیک🔧"],['text'=>"ساخت ربات سین ساز👁‍🗨"]
                ],
                [
                    ['text'=>"🔙منوی اصلی"]
                ],
            ],
            'resize_keyboard'=>true
        ])
    ]));
    save("data/$from_id/step.txt", "none");
}else {
    $token = $textmessage;

    $userbot = json_decode(file_get_contents('https://api.telegram.org/bot' . $token . '/getme'));
    //==================
    function objectToArrays($object)
    {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        return array_map("objectToArrays", $object);
    }

    $resultb = objectToArrays($userbot);
    $un = $resultb["result"]["username"];
    $ok = $resultb["ok"];
    if ($ok != 1) {
        //Token Not True
        SendMessage($chat_id, " توکن نا متعبر ");
    } else {
        SendMessage($chat_id, "در حال ساخت ربات ...\n ");
        if (file_exists("bots/$un/index.php")) {
            $source = file_get_contents("bot/index5.php");
            $source = str_replace("**TOKEN**", $token, $source);
            $source = str_replace("**ADMIN**", $from_id, $source);
            save("bots/$un/index.php", $source);
            file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

            var_dump(makereq('sendMessage', [
                'chat_id' => $update->message->chat->id,
                'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                'parse_mode' => 'MarkDown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                        ]

                    ],
                    'resize_keyboard' => true
                ])
            ]));
        } else {
            save("data/$from_id/tedad.txt", "1");
            save("data/$from_id/step.txt", "none");
            save("data/$from_id/bots.txt", "$un");

            mkdir("bots/$un");

            $source = file_get_contents("bot/index5.php");
            $source = str_replace("**TOKEN**", $token, $source);
            $source = str_replace("**ADMIN**", $from_id, $source);
            save("bots/$un/index.php", $source);
            file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

            var_dump(makereq('sendMessage', [
                'chat_id' => $update->message->chat->id,
                'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                'parse_mode' => 'MarkDown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                        ]

                    ],
                    'resize_keyboard' => true
                ])
            ]));
        }
    }
}
}

elseif ($step == 'create bot5') {
if ($textmessage == '🔙برگشت'){
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"یکی از دکمه های زیر را برای ساخت ربات کلیک کنید",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"ساخت ربات XO❌"],['text'=>"ساخت ربات کوتاه کننده لینک✈️"]
                ],
                [
                    ['text'=>"ساخت ربات چک کردن کد php 🏵"],['text'=>"ساخت ربات فال گیر🌀"]
                ],
                [
                    ['text'=>"ساخت روبات صلوات شمار📿"],['text'=>"ساخت ربات ماشین حساب📲"]
                ],
                [
                    ['text'=>"ساخت ربات گت اینفوℹ️"],['text'=>"ساخت ربات ساخت پیام مخفی📪"]
                ],
                [
                    ['text'=>"ساخت ربات @Bold 🔘"],['text'=>"ساخت ربات اینستا دانلود📥"]
                ],
                [
                    ['text'=>"ساخت ربات ادیت موزیک🔧"],['text'=>"ساخت ربات سین ساز👁‍🗨"]
                ],
                [
                    ['text'=>"🔙منوی اصلی"]
                ],
            ],
            'resize_keyboard'=>true
        ])
    ]));
    save("data/$from_id/step.txt", "none");
}else {
    $token = $textmessage;

    $userbot = json_decode(file_get_contents('https://api.telegram.org/bot' . $token . '/getme'));
    //==================
    function objectToArrays($object)
    {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        return array_map("objectToArrays", $object);
    }

    $resultb = objectToArrays($userbot);
    $un = $resultb["result"]["username"];
    $ok = $resultb["ok"];
    if ($ok != 1) {
        //Token Not True
        SendMessage($chat_id, "توکن نا معتبر!\nYour token is invalid");
    } else {
        SendMessage($chat_id, "در حال ساخت ربات ...\n ");
        if (file_exists("bots/$un/index.php")) {
            $source = file_get_contents("bot/index6.php");
            $source = str_replace("**TOKEN**", $token, $source);
            $source = str_replace("**ADMIN**", $from_id, $source);
            save("bots/$un/index.php", $source);
            file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

            var_dump(makereq('sendMessage', [
                'chat_id' => $update->message->chat->id,
                'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                'parse_mode' => 'MarkDown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                        ]

                    ],
                    'resize_keyboard' => true
                ])
            ]));
        } else {
            save("data/$from_id/tedad.txt", "1");
            save("data/$from_id/step.txt", "none");
            save("data/$from_id/bots.txt", "$un");

            mkdir("bots/$un");
            mkdir("bots/$un/data");

            $source = file_get_contents("bot/index6.php");
            $source = str_replace("**TOKEN**", $token, $source);
            $source = str_replace("**ADMIN**", $from_id, $source);
            save("bots/$un/index.php", $source);
            file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

            var_dump(makereq('sendMessage', [
                'chat_id' => $update->message->chat->id,
                'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                'parse_mode' => 'MarkDown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                        ]

                    ],
                    'resize_keyboard' => true
                ])
            ]));
        }
    }
}
}
elseif ($step == 'create bot6') {
    if ($textmessage == '🔙برگشت') {
        var_dump(makereq('sendMessage', [
            'chat_id' => $update->message->chat->id,
            'text' => "یکی از دکمه های زیر را برای ساخت ربات کلیک کنید",
            'parse_mode' => 'MarkDown',
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        ['text' => "ساخت ربات XO❌"], ['text' => "ساخت ربات کوتاه کننده لینک✈️"]
                    ],
                    [
                        ['text' => "ساخت ربات چک کردن کد php 🏵"], ['text' => "ساخت ربات فال گیر🌀"]
                    ],
                    [
                        ['text' => "ساخت روبات صلوات شمار📿"], ['text' => "ساخت ربات ماشین حساب📲"]
                    ],
                    [
                        ['text' => "ساخت ربات گت اینفوℹ️"], ['text' => "ساخت ربات ساخت پیام مخفی📪"]
                    ],
                    [
                        ['text' => "ساخت ربات @Bold 🔘"], ['text' => "ساخت ربات اینستا دانلود📥"]
                    ],
                    [
                        ['text' => "ساخت ربات ادیت موزیک🔧"],['text'=>"ساخت ربات سین ساز👁‍🗨"]
                    ],
                    [
                        ['text' => "🔙منوی اصلی"]
                    ],
                ],
                'resize_keyboard' => true
            ])
        ]));
        save("data/$from_id/step.txt", "none");
    } else {
        $token = $textmessage;

        $userbot = json_decode(file_get_contents('https://api.telegram.org/bot' . $token . '/getme'));
        //==================
        function objectToArrays($object)
        {
            if (!is_object($object) && !is_array($object)) {
                return $object;
            }
            if (is_object($object)) {
                $object = get_object_vars($object);
            }
            return array_map("objectToArrays", $object);
        }

        $resultb = objectToArrays($userbot);
        $un = $resultb["result"]["username"];
        $ok = $resultb["ok"];
        if ($ok != 1) {
            //Token Not True
            SendMessage($chat_id, " توکن نا متعبر ");
        } else {
            SendMessage($chat_id, "در حال ساخت ربات ...\n ");
            if (file_exists("bots/$un/index.php")) {
                $source = file_get_contents("bot/index2.php");
                $source = str_replace("**TOKEN**", $token, $source);
                $source = str_replace("**ADMIN**", $from_id, $source);
                save("bots/$un/index.php", $source);
                file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

                var_dump(makereq('sendMessage', [
                    'chat_id' => $update->message->chat->id,
                    'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                    'parse_mode' => 'MarkDown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                            ]

                        ],
                        'resize_keyboard' => true
                    ])
                ]));
            } else {
                save("data/$from_id/tedad.txt", "1");
                save("data/$from_id/step.txt", "none");
                save("data/$from_id/bots.txt", "$un");

                mkdir("bots/$un");

                $source = file_get_contents("bot/index2.php");
                $source = str_replace("**TOKEN**", $token, $source);
                $source = str_replace("**ADMIN**", $from_id, $source);
                save("bots/$un/index.php", $source);
                file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

                var_dump(makereq('sendMessage', [
                    'chat_id' => $update->message->chat->id,
                    'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                    'parse_mode' => 'MarkDown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                            ]

                        ],
                        'resize_keyboard' => true
                    ])
                ]));
            }
        }
    }
}

elseif ($step == 'create bot7') {
if ($textmessage == '🔙برگشت'){
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"یکی از دکمه های زیر را برای ساخت ربات کلیک کنید",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"ساخت ربات XO❌"],['text'=>"ساخت ربات کوتاه کننده لینک✈️"]
                ],
                [
                    ['text'=>"ساخت ربات چک کردن کد php 🏵"],['text'=>"ساخت ربات فال گیر🌀"]
                ],
                [
                    ['text'=>"ساخت روبات صلوات شمار📿"],['text'=>"ساخت ربات ماشین حساب📲"]
                ],
                [
                    ['text'=>"ساخت ربات گت اینفوℹ️"],['text'=>"ساخت ربات ساخت پیام مخفی📪"]
                ],
                [
                    ['text'=>"ساخت ربات @Bold 🔘"],['text'=>"ساخت ربات اینستا دانلود📥"]
                ],
                [
                    ['text'=>"ساخت ربات ادیت موزیک🔧"],['text'=>"ساخت ربات سین ساز👁‍🗨"]
                ],
                [
                    ['text'=>"🔙منوی اصلی"]
                ],
            ],
            'resize_keyboard'=>true
        ])
    ]));
    save("data/$from_id/step.txt", "none");
}else {
    $token = $textmessage;

    $userbot = json_decode(file_get_contents('https://api.telegram.org/bot' . $token . '/getme'));
    //==================
    function objectToArrays($object)
    {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        return array_map("objectToArrays", $object);
    }

    $resultb = objectToArrays($userbot);
    $un = $resultb["result"]["username"];
    $ok = $resultb["ok"];
    if ($ok != 1) {
        //Token Not True
        SendMessage($chat_id, "توکن نا معتبر!\nYour token is invalid");
    } else {
        SendMessage($chat_id, "در حال ساخت ربات ...\n ");
        if (file_exists("bots/$un/index.php")) {
            $source = file_get_contents("bot/index7.php");
            $source = str_replace("**TOKEN**", $token, $source);
            $source = str_replace("**ADMIN**", $from_id, $source);
            save("bots/$un/index.php", $source);
            file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

            var_dump(makereq('sendMessage', [
                'chat_id' => $update->message->chat->id,
                'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                'parse_mode' => 'MarkDown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                        ]

                    ],
                    'resize_keyboard' => true
                ])
            ]));
        } else {
            save("data/$from_id/tedad.txt", "1");
            save("data/$from_id/step.txt", "none");
            save("data/$from_id/bots.txt", "$un");

            mkdir("bots/$un");
            mkdir("bots/$un/data");

            $source = file_get_contents("bot/index7.php");
            $source = str_replace("**TOKEN**", $token, $source);
            $source = str_replace("**ADMIN**", $from_id, $source);
            save("bots/$un/index.php", $source);
            file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

            var_dump(makereq('sendMessage', [
                'chat_id' => $update->message->chat->id,
                'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                'parse_mode' => 'MarkDown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                        ]

                    ],
                    'resize_keyboard' => true
                ])
            ]));
        }
    }
}
}
elseif ($step == 'create bot8') {
if ($textmessage == '🔙برگشت'){
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"یکی از دکمه های زیر را برای ساخت ربات کلیک کنید",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"ساخت ربات XO❌"],['text'=>"ساخت ربات کوتاه کننده لینک✈️"]
                ],
                [
                    ['text'=>"ساخت ربات چک کردن کد php 🏵"],['text'=>"ساخت ربات فال گیر🌀"]
                ],
                [
                    ['text'=>"ساخت روبات صلوات شمار📿"],['text'=>"ساخت ربات ماشین حساب📲"]
                ],
                [
                    ['text'=>"ساخت ربات گت اینفوℹ️"],['text'=>"ساخت ربات ساخت پیام مخفی📪"]
                ],
                [
                    ['text'=>"ساخت ربات @Bold 🔘"],['text'=>"ساخت ربات اینستا دانلود📥"]
                ],
                [
                    ['text'=>"ساخت ربات ادیت موزیک🔧"],['text'=>"ساخت ربات سین ساز👁‍🗨"]
                ],
                [
                    ['text'=>"🔙منوی اصلی"]
                ],
            ],
            'resize_keyboard'=>true
        ])
    ]));
    save("data/$from_id/step.txt", "none");
}else {
    $token = $textmessage;

    $userbot = json_decode(file_get_contents('https://api.telegram.org/bot' . $token . '/getme'));
    //==================
    function objectToArrays($object)
    {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        return array_map("objectToArrays", $object);
    }

    $resultb = objectToArrays($userbot);
    $un = $resultb["result"]["username"];
    $ok = $resultb["ok"];
    if ($ok != 1) {
        //Token Not True
        SendMessage($chat_id, " توکن نا متعبر ");
    } else {
        SendMessage($chat_id, "در حال ساخت ربات ...\n ");
        if (file_exists("bots/$un/index.php")) {
            $source = file_get_contents("bot/index8.php");
            $source = str_replace("**TOKEN**", $token, $source);
            $source = str_replace("**ADMIN**", $from_id, $source);
            save("bots/$un/index.php", $source);
            file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

            var_dump(makereq('sendMessage', [
                'chat_id' => $update->message->chat->id,
                'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                'parse_mode' => 'MarkDown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                        ]

                    ],
                    'resize_keyboard' => true
                ])
            ]));
        } else {
            save("data/$from_id/tedad.txt", "1");
            save("data/$from_id/step.txt", "none");
            save("data/$from_id/bots.txt", "$un");

            mkdir("bots/$un");

            $source = file_get_contents("bot/index8.php");
            $source = str_replace("**TOKEN**", $token, $source);
            $source = str_replace("**ADMIN**", $from_id, $source);
            save("bots/$un/index.php", $source);
            file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

            var_dump(makereq('sendMessage', [
                'chat_id' => $update->message->chat->id,
                'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                'parse_mode' => 'MarkDown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                        ]

                    ],
                    'resize_keyboard' => true
                ])
            ]));
        }
    }
}
}

elseif ($step == 'create bot9') {
    if ($textmessage == '🔙برگشت') {
        var_dump(makereq('sendMessage', [
            'chat_id' => $update->message->chat->id,
            'text' => "یکی از دکمه های زیر را برای ساخت ربات کلیک کنید",
            'parse_mode' => 'MarkDown',
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        ['text' => "ساخت ربات XO❌"], ['text' => "ساخت ربات کوتاه کننده لینک✈️"]
                    ],
                    [
                        ['text' => "ساخت ربات چک کردن کد php 🏵"], ['text' => "ساخت ربات فال گیر🌀"]
                    ],
                    [
                        ['text' => "ساخت روبات صلوات شمار📿"], ['text' => "ساخت ربات ماشین حساب📲"]
                    ],
                    [
                        ['text' => "ساخت ربات گت اینفوℹ️"], ['text' => "ساخت ربات ساخت پیام مخفی📪"]
                    ],
                    [
                        ['text' => "ساخت ربات @Bold 🔘"], ['text' => "ساخت ربات اینستا دانلود📥"]
                    ],
                    [
                        ['text' => "ساخت ربات ادیت موزیک🔧"],['text'=>"ساخت ربات سین ساز👁‍🗨"]
                    ],
                    [
                        ['text' => "🔙منوی اصلی"]
                    ],
                ],
                'resize_keyboard' => true
            ])
        ]));
        save("data/$from_id/step.txt", "none");
    } else {
        $token = $textmessage;

        $userbot = json_decode(file_get_contents('https://api.telegram.org/bot' . $token . '/getme'));
        //==================
        function objectToArrays($object)
        {
            if (!is_object($object) && !is_array($object)) {
                return $object;
            }
            if (is_object($object)) {
                $object = get_object_vars($object);
            }
            return array_map("objectToArrays", $object);
        }

        $resultb = objectToArrays($userbot);
        $un = $resultb["result"]["username"];
        $ok = $resultb["ok"];
        if ($ok != 1) {
            //Token Not True
            SendMessage($chat_id, "توکن نا معتبر!\nYour token is invalid");
        } else {
            SendMessage($chat_id, "در حال ساخت ربات ...\n ");
            if (file_exists("bots/$un/index.php")) {
                $source = file_get_contents("bot/index4.php");
                $source = str_replace("**TOKEN**", $token, $source);
                $source = str_replace("**ADMIN**", $from_id, $source);
                save("bots/$un/index.php", $source);
                file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

                var_dump(makereq('sendMessage', [
                    'chat_id' => $update->message->chat->id,
                    'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                    'parse_mode' => 'MarkDown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                            ]

                        ],
                        'resize_keyboard' => true
                    ])
                ]));
            } else {
                save("data/$from_id/tedad.txt", "1");
                save("data/$from_id/step.txt", "none");
                save("data/$from_id/bots.txt", "$un");

                mkdir("bots/$un");
                mkdir("bots/$un/data");

                $source = file_get_contents("bot/index4.php");
                $source = str_replace("**TOKEN**", $token, $source);
                $source = str_replace("**ADMIN**", $from_id, $source);
                save("bots/$un/index.php", $source);
                file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

                var_dump(makereq('sendMessage', [
                    'chat_id' => $update->message->chat->id,
                    'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                    'parse_mode' => 'MarkDown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                            ]

                        ],
                        'resize_keyboard' => true
                    ])
                ]));
            }
        }
    }
}
elseif ($step == 'create bot10') {
    if ($textmessage == '🔙برگشت') {
        var_dump(makereq('sendMessage', [
            'chat_id' => $update->message->chat->id,
            'text' => "یکی از دکمه های زیر را برای ساخت ربات کلیک کنید",
            'parse_mode' => 'MarkDown',
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        ['text' => "ساخت ربات XO❌"], ['text' => "ساخت ربات کوتاه کننده لینک✈️"]
                    ],
                    [
                        ['text' => "ساخت ربات چک کردن کد php 🏵"], ['text' => "ساخت ربات فال گیر🌀"]
                    ],
                    [
                        ['text' => "ساخت روبات صلوات شمار📿"], ['text' => "ساخت ربات ماشین حساب📲"]
                    ],
                    [
                        ['text' => "ساخت ربات گت اینفوℹ️"], ['text' => "ساخت ربات ساخت پیام مخفی📪"]
                    ],
                    [
                        ['text' => "ساخت ربات @Bold 🔘"], ['text' => "ساخت ربات اینستا دانلود📥"]
                    ],
                    [
                        ['text' => "ساخت ربات ادیت موزیک🔧"],['text'=>"ساخت ربات سین ساز👁‍🗨"]
                    ],
                    [
                        ['text' => "🔙منوی اصلی"]
                    ],
                ],
                'resize_keyboard' => true
            ])
        ]));
        save("data/$from_id/step.txt", "none");
    } else {
        $token = $textmessage;

        $userbot = json_decode(file_get_contents('https://api.telegram.org/bot' . $token . '/getme'));
        //==================
        function objectToArrays($object)
        {
            if (!is_object($object) && !is_array($object)) {
                return $object;
            }
            if (is_object($object)) {
                $object = get_object_vars($object);
            }
            return array_map("objectToArrays", $object);
        }

        $resultb = objectToArrays($userbot);
        $un = $resultb["result"]["username"];
        $ok = $resultb["ok"];
        if ($ok != 1) {
            //Token Not True
            SendMessage($chat_id, " توکن نا متعبر ");
        } else {
            SendMessage($chat_id, "در حال ساخت ربات ...\n ");
            if (file_exists("bots/$un/index.php")) {
                $source = file_get_contents("bot/index10.php");
                $source = str_replace("**TOKEN**", $token, $source);
                $source = str_replace("**ADMIN**", $from_id, $source);
                save("bots/$un/index.php", $source);
                file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

                var_dump(makereq('sendMessage', [
                    'chat_id' => $update->message->chat->id,
                    'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                    'parse_mode' => 'MarkDown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                            ]

                        ],
                        'resize_keyboard' => true
                    ])
                ]));
            } else {
                save("data/$from_id/tedad.txt", "1");
                save("data/$from_id/step.txt", "none");
                save("data/$from_id/bots.txt", "$un");

                mkdir("bots/$un");

                $source = file_get_contents("bot/index10.php");
                $source = str_replace("**TOKEN**", $token, $source);
                $source = str_replace("**ADMIN**", $from_id, $source);
                save("bots/$un/index.php", $source);
                file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

                var_dump(makereq('sendMessage', [
                    'chat_id' => $update->message->chat->id,
                    'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                    'parse_mode' => 'MarkDown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                            ]

                        ],
                        'resize_keyboard' => true
                    ])
                ]));
            }
        }
    }
}
elseif ($step == 'create bot11') {
    if ($textmessage == '🔙برگشت') {
        var_dump(makereq('sendMessage', [
            'chat_id' => $update->message->chat->id,
            'text' => "یکی از دکمه های زیر را برای ساخت ربات کلیک کنید",
            'parse_mode' => 'MarkDown',
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        ['text' => "ساخت ربات XO❌"], ['text' => "ساخت ربات کوتاه کننده لینک✈️"]
                    ],
                    [
                        ['text' => "ساخت ربات چک کردن کد php 🏵"], ['text' => "ساخت ربات فال گیر🌀"]
                    ],
                    [
                        ['text' => "ساخت روبات صلوات شمار📿"], ['text' => "ساخت ربات ماشین حساب📲"]
                    ],
                    [
                        ['text' => "ساخت ربات گت اینفوℹ️"], ['text' => "ساخت ربات ساخت پیام مخفی📪"]
                    ],
                    [
                        ['text' => "ساخت ربات @Bold 🔘"], ['text' => "ساخت ربات اینستا دانلود📥"]
                    ],
                    [
                        ['text' => "ساخت ربات ادیت موزیک🔧"],['text'=>"ساخت ربات سین ساز👁‍🗨"]
                    ],
                    [
                        ['text' => "🔙منوی اصلی"]
                    ],
                ],
                'resize_keyboard' => true
            ])
        ]));
        save("data/$from_id/step.txt", "none");
    } else {
        $token = $textmessage;

        $userbot = json_decode(file_get_contents('https://api.telegram.org/bot' . $token . '/getme'));
        //==================
        function objectToArrays($object)
        {
            if (!is_object($object) && !is_array($object)) {
                return $object;
            }
            if (is_object($object)) {
                $object = get_object_vars($object);
            }
            return array_map("objectToArrays", $object);
        }

        $resultb = objectToArrays($userbot);
        $un = $resultb["result"]["username"];
        $ok = $resultb["ok"];
        if ($ok != 1) {
            //Token Not True
            SendMessage($chat_id, " توکن نا متعبر ");
        } else {
            SendMessage($chat_id, "در حال ساخت ربات ...\n ");
            if (file_exists("bots/$un/index.php")) {
                $source = file_get_contents("bot/index11.php");
                $source = str_replace("**TOKEN**", $token, $source);
                $source = str_replace("**ADMIN**", $from_id, $source);
                save("bots/$un/index.php", $source);
                file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

                var_dump(makereq('sendMessage', [
                    'chat_id' => $update->message->chat->id,
                    'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                    'parse_mode' => 'MarkDown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                            ]

                        ],
                        'resize_keyboard' => true
                    ])
                ]));
            } else {
                save("data/$from_id/tedad.txt", "1");
                save("data/$from_id/step.txt", "none");
                save("data/$from_id/bots.txt", "$un");

                mkdir("bots/$un");

                $source = file_get_contents("bot/index11.php");
                $source = str_replace("**TOKEN**", $token, $source);
                $source = str_replace("**ADMIN**", $from_id, $source);
                save("bots/$un/index.php", $source);
                file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

                var_dump(makereq('sendMessage', [
                    'chat_id' => $update->message->chat->id,
                    'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                    'parse_mode' => 'MarkDown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                            ]

                        ],
                        'resize_keyboard' => true
                    ])
                ]));
            }
        }
    }
}
elseif ($step == 'create bot12') {
    if ($textmessage == '🔙برگشت') {
        var_dump(makereq('sendMessage', [
            'chat_id' => $update->message->chat->id,
            'text' => "یکی از دکمه های زیر را برای ساخت ربات کلیک کنید",
            'parse_mode' => 'MarkDown',
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        ['text' => "ساخت ربات XO❌"], ['text' => "ساخت ربات کوتاه کننده لینک✈️"]
                    ],
                    [
                        ['text' => "ساخت ربات چک کردن کد php 🏵"], ['text' => "ساخت ربات فال گیر🌀"]
                    ],
                    [
                        ['text' => "ساخت روبات صلوات شمار📿"], ['text' => "ساخت ربات ماشین حساب📲"]
                    ],
                    [
                        ['text' => "ساخت ربات گت اینفوℹ️"], ['text' => "ساخت ربات ساخت پیام مخفی📪"]
                    ],
                    [
                        ['text' => "ساخت ربات @Bold 🔘"], ['text' => "ساخت ربات اینستا دانلود📥"]
                    ],
                    [
                        ['text' => "ساخت ربات ادیت موزیک🔧"],['text'=>"ساخت ربات سین ساز👁‍🗨"]
                    ],
                    [
                        ['text' => "🔙منوی اصلی"]
                    ],
                ],
                'resize_keyboard' => true
            ])
        ]));
        save("data/$from_id/step.txt", "none");
    } else {
        $token = $textmessage;

        $userbot = json_decode(file_get_contents('https://api.telegram.org/bot' . $token . '/getme'));
        //==================
        function objectToArrays($object)
        {
            if (!is_object($object) && !is_array($object)) {
                return $object;
            }
            if (is_object($object)) {
                $object = get_object_vars($object);
            }
            return array_map("objectToArrays", $object);
        }

        $resultb = objectToArrays($userbot);
        $un = $resultb["result"]["username"];
        $ok = $resultb["ok"];
        if ($ok != 1) {
            //Token Not True
            SendMessage($chat_id, " توکن نا متعبر ");
        } else {
            SendMessage($chat_id, "در حال ساخت ربات ...\n");
            if (file_exists("bots/$un/index.php")) {
                $source = file_get_contents("bot/index12.php");
                $source = str_replace("**TOKEN**", $token, $source);
                $source = str_replace("**ADMIN**", $from_id, $source);
                save("bots/$un/index.php", $source);
                file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

                var_dump(makereq('sendMessage', [
                    'chat_id' => $update->message->chat->id,
                    'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                    'parse_mode' => 'MarkDown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                            ]

                        ],
                        'resize_keyboard' => true
                    ])
                ]));
            } else {
                save("data/$from_id/tedad.txt", "1");
                save("data/$from_id/step.txt", "none");
                save("data/$from_id/bots.txt", "$un");

                mkdir("bots/$un");

                $source = file_get_contents("bot/index12.php");
                $source = str_replace("**TOKEN**", $token, $source);
                $source = str_replace("**ADMIN**", $from_id, $source);
                save("bots/$un/index.php", $source);
                file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

                var_dump(makereq('sendMessage', [
                    'chat_id' => $update->message->chat->id,
                    'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                    'parse_mode' => 'MarkDown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                            ]

                        ],
                        'resize_keyboard' => true
                    ])
                ]));
            }
        }
    }
}
elseif ($step == 'create bot13') {
    if ($textmessage == '🔙برگشت') {
        var_dump(makereq('sendMessage', [
            'chat_id' => $update->message->chat->id,
            'text' => "یکی از دکمه های زیر را برای ساخت ربات کلیک کنید",
            'parse_mode' => 'MarkDown',
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        ['text' => "ساخت ربات XO❌"], ['text' => "ساخت ربات کوتاه کننده لینک✈️"]
                    ],
                    [
                        ['text' => "ساخت ربات چک کردن کد php 🏵"], ['text' => "ساخت ربات فال گیر🌀"]
                    ],
                    [
                        ['text' => "ساخت روبات صلوات شمار📿"], ['text' => "ساخت ربات ماشین حساب📲"]
                    ],
                    [
                        ['text' => "ساخت ربات گت اینفوℹ️"], ['text' => "ساخت ربات ساخت پیام مخفی📪"]
                    ],
                    [
                        ['text' => "ساخت ربات @Bold 🔘"], ['text' => "ساخت ربات اینستا دانلود📥"]
                    ],
                    [
                        ['text' => "ساخت ربات ادیت موزیک🔧"],['text'=>"ساخت ربات سین ساز👁‍🗨"]
                    ],
                    [
                        ['text' => "🔙منوی اصلی"]
                    ],
                ],
                'resize_keyboard' => true
            ])
        ]));
        save("data/$from_id/step.txt", "none");
    } else {
        $token = $textmessage;

        $userbot = json_decode(file_get_contents('https://api.telegram.org/bot' . $token . '/getme'));
        //==================
        function objectToArrays($object)
        {
            if (!is_object($object) && !is_array($object)) {
                return $object;
            }
            if (is_object($object)) {
                $object = get_object_vars($object);
            }
            return array_map("objectToArrays", $object);
        }

        $resultb = objectToArrays($userbot);
        $un = $resultb["result"]["username"];
        $ok = $resultb["ok"];
        if ($ok != 1) {
            //Token Not True
            SendMessage($chat_id, " توکن نا متعبر ");
        } else {
            SendMessage($chat_id, "در حال ساخت ربات ...\n ");
            if (file_exists("bots/$un/index.php")) {
                $source = file_get_contents("bot/index13.php");
                $source = str_replace("**TOKEN**", $token, $source);
                $source = str_replace("**ADMIN**", $from_id, $source);
                save("bots/$un/index.php", $source);
                file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

                var_dump(makereq('sendMessage', [
                    'chat_id' => $update->message->chat->id,
                    'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                    'parse_mode' => 'MarkDown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                            ]

                        ],
                        'resize_keyboard' => true
                    ])
                ]));
            } else {
                save("data/$from_id/tedad.txt", "1");
                save("data/$from_id/step.txt", "none");
                save("data/$from_id/bots.txt", "$un");

                mkdir("bots/$un");

                $source = file_get_contents("bot/index13.php");
                $source = str_replace("**TOKEN**", $token, $source);
                $source = str_replace("**ADMIN**", $from_id, $source);
                save("bots/$un/index.php", $source);
                file_get_contents("http://api.telegram.org/bot" . $token . "/setwebhook?url=https://gravitybab.000webhostapp.com/buildabot/bots/$un/index.php");

                var_dump(makereq('sendMessage', [
                    'chat_id' => $update->message->chat->id,
                    'text' => "ربات شما با موفقیت ساخته شد.

برای ورود به ربات خود کلیک کنید.",
                    'parse_mode' => 'MarkDown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => 'ورود به ربات', 'url' => "https://telegram.me/$un"]
                            ]

                        ],
                        'resize_keyboard' => true
                    ])
                ]));
            }
        }
    }
}
///---------------
if(isset($update->callback_query)){
    $callbackMessage = '';
    var_dump(makereq('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>$callbackMessage
    ]));
    $chat_id = $update->callback_query->message->chat->id;

    $message_id = $update->callback_query->message->message_id;
    $data = $update->callback_query->data;
    if (strpos($data, "del") !== false ) {
        $botun = str_replace("del ","",$data);
        unlink("bots/".$botun."/index.php");
        save("data/$chat_id/bots.txt","");
        save("data/$chat_id/tedad.txt","0");
        var_dump(
            makereq('editMessageText',[
                'chat_id'=>$chat_id,
                'message_id'=>$message_id,
                'text'=>"دوست عزیز $name ربات شما با موفقیت حذف شد😉",
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [
                            ['text'=>"به کانال ما بپیوندید🤓",'url'=>"https://telegram.me/legragame"]
                        ]
                    ]
                ])
            ])
        );
    }
    else {
        var_dump(
            makereq('editMessageText',[
                'chat_id'=>$chat_id,
                'message_id'=>$message_id,
                'text'=>"خطا😰",
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [
                            ['text'=>"به کانال ما بپیوندید🤓",'url'=>"https://telegram.me/tikapp"]
                        ]
                    ]
                ])
            ])
        );
    }
}

elseif ($textmessage == '🔙منوی اصلی') {
    save("data/$from_id/step.txt","none");
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"🔃 به منو برگشتید",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"📚لیست ربات های من🤖"],['text'=>"🗑حذف ربات🤖"]
                ],
                [
                    ['text'=>"ساخت ربات پیشرفته😋"]
                ],
                [
                    ['text'=>"❗️ راهنما"],['text'=>"کانال ما🔉"],['text'=>"🔷 قوانین"]
                ],

            ],
            'resize_keyboard'=>true
        ])
    ]));
}
elseif($textmessage == '📚لیست ربات های من🤖')
{
    $botname = file_get_contents("data/$from_id/bots.txt");
    if ($botname == "") {
        SendMessage($chat_id,"شما هنوز هیچ رباتی نساخته اید !");
        return;
    }
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"لیست ربات های شما : ",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [
                    ['text'=>"👉 @".$botname,'url'=>"https://telegram.me/".$botname]
                ]
            ]
        ])
    ]));
}
elseif ($textmessage == '🔙برگشت'){
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"یکی از دکمه های زیر را برای ساخت ربات کلیک کنید",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"ساخت ربات XO❌"],['text'=>"ساخت ربات کوتاه کننده لینک✈️"]
                ],
                [
                    ['text'=>"ساخت ربات چک کردن کد php 🏵"],['text'=>"ساخت ربات فال گیر🌀️"]
                ],
                [
                    ['text'=>"ساخت روبات صلوات شمار📿"],['text'=>"ساخت ربات ماشین حساب📲"]
                ],
                [
                    ['text'=>"ساخت ربات گت اینفوℹ️"],['text'=>"ساخت ربات ساخت پیام مخفی📪"]
                ],
                [
                    ['text'=>"ساخت ربات @Bold 🔘"],['text'=>"ساخت ربات اینستا دانلود📥"]
                ],
                [
                    ['text'=>"ساخت ربات ادیت موزیک🔧"],['text'=>"ساخت ربات سین ساز👁‍🗨"]
                ],
                [
                    ['text'=>"🔙منوی اصلی"]
                ],
            ],
            'resize_keyboard'=>true
        ])
    ]));
}
elseif ($textmessage == 'ساخت ربات پیشرفته😋'){
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"یکی از دکمه های زیر را برای ساخت ربات کلیک کنید",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"ساخت ربات XO❌"],['text'=>"ساخت ربات کوتاه کننده لینک✈️"]
                ],
                [
                    ['text'=>"ساخت ربات چک کردن کد php 🏵"],['text'=>"ساخت ربات فال گیر🌀️"]
                ],
                [
                    ['text'=>"ساخت روبات صلوات شمار📿"],['text'=>"ساخت ربات ماشین حساب📲"]
                ],
                [
                    ['text'=>"ساخت ربات گت اینفوℹ️"],['text'=>"ساخت ربات ساخت پیام مخفی📪"]
                ],
                [
                    ['text'=>"ساخت ربات @Bold 🔘"],['text'=>"ساخت ربات اینستا دانلود📥"]
                ],
                [
                    ['text'=>"ساخت ربات ادیت موزیک🔧"],['text'=>"ساخت ربات سین ساز👁‍🗨"]
                ],
                [
                    ['text'=>"🔙منوی اصلی"]
                ],
            ],
            'resize_keyboard'=>true
        ])
    ]));
}
elseif($textmessage == 'کانال ما🔉'){
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"📌 براي دريافت اخرين آپديت ها كليك كنيد :",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [
                    ['text'=>"📢عضویت در کانال",'url'=>"https://telegram.me/legragame"]
                ]
            ]
        ])
    ]));
}
elseif($textmessage == '/start' )
{
    if (!file_exists("data/$from_id/step.txt")) {
        mkdir("data/$from_id");
        save("data/$from_id/step.txt","none");
        save("data/$from_id/tedad.txt","0");
        save("data/$from_id/bots.txt","");
        $myfile2 = fopen("data/users.txt", "a") or die("Unable to open file!");
        fwrite($myfile2, "$from_id\n");
        fclose($myfile2);
    }

    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"سلام دوست عزیز $frist_name 😊

 میخوای ربات های باحال بسازی😅
دیگع از ربات های هاجی ربوت و کریت ربوت و....  خسته شدی😢

خوب چرا نگرانی😐
من اینجام😊
برات کای ربات باحال اماده کردم که دیگرانو شگفت زده کنی😅

فقط باید بری ربات
[BotFather](http://telegram.me/BotFather)
و برای خودت یه ربات بسازی😁

بعد بهتون یه توکن میده که من همونو لازم داره😅
مانند:
123456789:Hhakaskdvmsovmsovb
بعد من به شما پیغام میدم که ربات شما ساخت شده است و با دستور /start از رباتتون لذت ببرید 

[😋عضویت در کانال من](http://telegram.me/legragame) .",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"📚لیست ربات های من🤖"],['text'=>"🗑حذف ربات🤖"]
                ],
                [
                    ['text'=>"ساخت ربات پیشرفته😋"]
                ],
                [
                    ['text'=>"❗️ راهنما"],['text'=>"کانال ما🔉"],['text'=>"🔷 قوانین"]
                ],
            ],
            'resize_keyboard'=>true
        ])
    ]));
}
elseif($textmessage == '🔷 قوانین') {
    SendMessage($chat_id, "⏺اطلاعات ثبت شده در ربات های ساخته شده توسط من از قبیل اطلاعات پروفایل نزد مدیران من محفوظ است و در اختیار اشخاص حقیقی یا حقوقی قرار نخواهد گرفت.

⏺مسئولیت پیام های رد و بدل شده در هر ربات با مدیر آن ربات میباشد و من هیچ گونه مسئولیتی قبول نمیکنم.

⏺رعایت حریم خصوصی و حقوقی افراد از جمله، عدم اهانت به شخصیت های مذهبی، سیاسی، حقیقی و حقوقی کشور و به ویژه کاربران ربات ضروری می باشد.");
}
elseif($textmessage == '❗️ راهنما') {
    SendMessage($chat_id, "دوست عزیز [$frist_name $last_name](https://telegram.me/$username) شما با استفاده از من میتوانید ربات های پیشرفته بسازید😊

فعلا نسخه من 1هست🙈
ولی بزودی نسخه جدید من رونمایی میشه با امکانات فوق العاده☺️

خوب شما با استفاده از دکمه های که زیر صفحه نمایان شده هست با من کار کنید و از امکانات فعلی من استفاده کنید😅

نظر یا انتقادی درباره من دارید با استفاده از دکمه ارسال نظر و انتقاد با ادمین های من در میان بزارید😅");
}
elseif ($textmessage == '🗑حذف ربات🤖' ) {
    if (file_exists("data/$from_id/step.txt")) {

    }
    $botname = file_get_contents("data/$from_id/bots.txt");
    if ($botname == "") {
        SendMessage($chat_id,"شما هنوز هیچ رباتی نساخته اید !");

    }
    else {
        save("data/$from_id/step.txt","delete");


        var_dump(makereq('sendMessage',[
            'chat_id'=>$update->message->chat->id,
            'text'=>"یکی از ربات های خود را انتخاب کنید :",
            'parse_mode'=>'MarkDown',
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"👉 @".$botname,'callback_data'=>"del ".$botname]
                    ]
                ]
            ])
        ]));

        /*
        var_dump(makereq('sendMessage',[
                    'chat_id'=>$update->message->chat->id,
                    'text'=>"یکی از ربات های خود را جهت پاک کردن انتخاب کنید : ",
                'parse_mode'=>'MarkDown',
                    'reply_markup'=>json_encode([
                        'keyboard'=>[
                        [
                        ['text'=>$botname]
                        ],
                        [
                           ['text'=>"🔙برگشت"]
                        ]

                        ],
                        'resize_keyboard'=>true
                       ])
                    ])); */
    }
}
//__________---------//
elseif ($textmessage == 'ساخت ربات گت اینفوℹ️' ) {
    save("data/$from_id/step.txt","create bot");
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"توکن را وارد کنید :",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"🔙برگشت"]
                ]

            ],
            'resize_keyboard'=>true
        ])
    ]));

}
elseif ($textmessage == 'ساخت ربات چک کردن کد php 🏵' ) {
    save("data/$from_id/step.txt","create bot2");
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"توکن را وارد کنید :",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"🔙برگشت"]
                ]

            ],
            'resize_keyboard'=>true
        ])
    ]));
}
elseif ($textmessage == 'ساخت ربات کوتاه کننده لینک✈️' ) {
    save("data/$from_id/step.txt","create bot3");
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"توکن را وارد کنید :",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"🔙برگشت"]
                ]

            ],
            'resize_keyboard'=>true
        ])
    ]));
}
elseif ($textmessage == 'ساخت ربات @Bold 🔘' ) {
    save("data/$from_id/step.txt","create bot4");
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"توکن را وارد کنید :",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"🔙برگشت"]
                ]

            ],
            'resize_keyboard'=>true
        ])
    ]));
}
elseif ($textmessage == 'ساخت ربات فال گیر🌀️' ) {
    save("data/$from_id/step.txt","create bot5");
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"توکن را وارد کنید :",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"🔙برگشت"]
                ]

            ],
            'resize_keyboard'=>true
        ])
    ]));
}
elseif ($textmessage == 'ساخت روبات صلوات شمار📿' ) {
    save("data/$from_id/step.txt","create bot6");
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"توکن را وارد کنید :",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"🔙برگشت"]
                ]

            ],
            'resize_keyboard'=>true
        ])
    ]));
}
elseif ($textmessage == 'ساخت ربات XO❌' ) {
    save("data/$from_id/step.txt","create bot7");
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"توکن را وارد کنید :",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"🔙برگشت"]
                ]

            ],
            'resize_keyboard'=>true
        ])
    ]));
}
elseif ($textmessage == 'ساخت ربات ماشین حساب📲️' ) {
    save("data/$from_id/step.txt","create bot8");
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"توکن را وارد کنید :",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"🔙برگشت"]
                ]

            ],
            'resize_keyboard'=>true
        ])
    ]));
}
elseif ($textmessage == 'ساخت ربات ساخت پیام مخفی📪️' ) {
    save("data/$from_id/step.txt","create bot9");
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"توکن را وارد کنید :",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"🔙برگشت"]
                ]

            ],
            'resize_keyboard'=>true
        ])
    ]));
}
elseif ($textmessage == 'ساخت ربات متن عاشقانه💔️' ) {
    save("data/$from_id/step.txt","create bot10");
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"توکن را وارد کنید :",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"🔙برگشت"]
                ]

            ],
            'resize_keyboard'=>true
        ])
    ]));
}
elseif ($textmessage == 'ساخت ربات اینستا دانلود📥' ) {
    save("data/$from_id/step.txt","create bot11");
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"توکن را وارد کنید :",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"🔙برگشت"]
                ]

            ],
            'resize_keyboard'=>true
        ])
    ]));
}
elseif ($textmessage == 'ساخت ربات ادیت موزیک🔧' ) {
    save("data/$from_id/step.txt","create bot12");
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"توکن را وارد کنید :",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"🔙برگشت"]
                ]

            ],
            'resize_keyboard'=>true
        ])
    ]));
}
elseif ($textmessage == 'ساخت ربات سین ساز👁‍🗨' ) {
    save("data/$from_id/step.txt","create bot13");
    var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"توکن را وارد کنید :",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"🔙برگشت"]
                ]

            ],
            'resize_keyboard'=>true
        ])
    ]));
}
///-------------
//------pannel modiriat
elseif ($textmessage == '/manager' && $from_id == $admin) { 
    var_dump(makereq('sendMessage',[ 
        'chat_id'=>$update->message->chat->id, 
        'text'=>"سلام ادمین عزیز 
به پنل مدیریت خوش آمدید 
یکی از دکمه هارو انتخاب کن.", 
        'parse_mode'=>'MarkDown', 
        'reply_markup'=>json_encode([ 
            'keyboard'=>[ 
                [ 
                    ['text'=>"🙃آمار"],['text'=>"ارسال به همه📬"] 
                ], 
                [ 
                    ['text'=>"📢 فروارد همگانی"],['text'=>"🔙منوی اصلی"] 
                ] 
 
            ], 
            'resize_keyboard'=>true 
        ]) 
    ])); 
} 
 
elseif ($textmessage == '🙃آمار' && $from_id == $admin) { 
    $number = count(scandir("bots"))-1; 
    $usercount = -1; 
    $fp = fopen( "data/users.txt", 'r'); 
    while( !feof( $fp)) { 
        fgets( $fp); 
        $usercount ++; 
    } 
    fclose( $fp); 
    SendMessage($chat_id,"👥اعضای ربات : ".$usercount."\n🤖تعداد رباتهای فعال : $number"); 
} 
elseif ($textmessage == 'ارسال به همه📬') 
    if ($from_id == $admin) 
    { 
        save("data/$from_id/step.txt","sendtoall"); 
        var_dump(makereq('sendMessage',[ 
                    'chat_id'=>$update->message->chat->id, 
                    'text'=>"پیام خود را ارسال کنید : ", 
                    'parse_mode'=>'MarkDown', 
                    'reply_markup'=>json_encode(['keyboard'=> 
                        [[['text'=>"🔙منوی اصلی"]]], 
                        'resize_keyboard'=>true 
                    ]) 
                ] 
            ) 
        ); 
    } 
    else 
    { 
        SendMessage($chat_id,"شما ادمین نیستید."); 
    } 
elseif ($step == 'sendtoall') 
{ 
    SendMessage($chat_id,"پیام در حال ارسال میباشد...⏰"); 
    save("data/$from_id/step.txt","none"); 
    $fp = fopen( "data/users.txt", 'r'); 
    while( !feof( $fp)) { 
        $ckar = fgets( $fp); 
        SendMessage($ckar,$textmessage); 
    } 
    SendMessage($chat_id,"پیام شما با موفقیت به تمام کاربران ارسال شد👍"); 
} 
elseif ($textmessage == '📢 فروارد همگانی') 
if ($from_id == $admin) 
{ 
save("data/$from_id/step.txt","fortoall"); 
var_dump(makereq('sendMessage',[ 
'chat_id'=>$update->message->chat->id, 
'text'=>"🔹 لطفا پیام خود را فوروارد کنید :", 
'parse_mode'=>'MarkDown', 
                    'reply_markup'=>json_encode(['keyboard'=> 
                        [[['text'=>"🔙منوی اصلی"]]], 
                        'resize_keyboard'=>true 
                    ]) 
 
                               ] 
        ) 
    ); 
} 
else 
{ 
SendMessage($chat_id,"😐📛شما ادمین نیستید."); 
} 
elseif ($step == 'fortoall') 
{ 
SendMessage($chat_id,"📢 در حال فروارد پیام . . ."); 
save("data/$from_id/step.txt","none"); 
$forp = fopen( "data/users.txt", 'r'); 
while( !feof( $forp)) { 
$fakar = fgets( $forp); 
Forward($fakar, $chat_id,$message_id); 
  } 
   makereq('sendMessage',[ 
   'chat_id'=>$chat_id, 
   'text'=>"✅ پیام شما به همه ی کاربران ربات فروارد شد.", 
   ]); 
}
//creator//
elseif($text == '/creator'){

sendaction($chat_id, typing);

        bot('sendmessage', [

                'chat_id' => $chat_id,

                'text' =>"این ربات توسط @SonOfTheGod ساخته شده است 😌",

            ]);

        }
?>
