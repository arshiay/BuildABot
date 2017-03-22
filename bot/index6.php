<?php
ob_start();
//@Roonx_Team
define('API_KEY','**TOKEN**');
$admin =  "**ADMIN";
$update = json_decode(file_get_contents('php://input'));
$from_id = $update->message->from->id;
$chat_id = $update->message->chat->id;
$chatid = $update->callback_query->message->chat->id;
$data = $update->callback_query->data;
$text = $update->message->text;
$message_id = $update->callback_query->message->message_id;
$message_id_feed = $update->message->message_id;
$fal = file_get_contents("http://api.roonx.com/falhafez/index.php");
function roonx($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
if(preg_match('/^\/([Ss]tart)/',$text)){
roonx('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"سلام به ربات فال حافظ خوش آمدی(:
اول نیت کن بعد روی دکمه بزن",
    'parse_mode'=>'html',
   'reply_markup'=>json_encode([
      'inline_keyboard'=>[
          [
     ['text'=>'نیت کردم','callback_data'=>'fal']
          ]
        ]
		])
  ]);
}elseif(preg_match('/^\/([Ff]al)/',$text)){
roonx('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>$fal,
    'parse_mode'=>'html'
  ]);
}
elseif ($data == "fal") {
  roonx('editMessagetext',[
    'chat_id'=>$chatid,
	'message_id'=>$message_id,
    'text'=>$fal,
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
      'inline_keyboard'=>[
        [
          ['text'=>'دوباره','callback_data'=>'fal']
        ],
	  [
		['text'=>'برگردیم اول ◀','callback_data'=>'menu']
      ]
      ]
    ])
  ]);
 }
elseif ($data == "menu") {
  roonx('editMessagetext',[
    'chat_id'=>$chatid,
	'message_id'=>$message_id,
    'text'=>"سلام به ربات فال حافظ خوش آمدی(:
اول نیت کن بعد روی دکمه بزن",
    'parse_mode'=>'html',
   'reply_markup'=>json_encode([
      'inline_keyboard'=>[
          [
     ['text'=>'نیت کردم','callback_data'=>'fal']
          ]
      ]
    ])
  ]);
 }
elseif(preg_match('/^\/([Ss]tats)/',$text) and $from_id == $admin){
    $user = file_get_contents('Member.txt');
    $member_id = explode("\n",$user);
    $member_count = count($member_id) -1;
    roonx('sendMessage',[
      'chat_id'=>$chat_id,
      'text'=>"تعداد کل اعضا: $member_count",
      'parse_mode'=>'HTML'
    ]);
}
$user = file_get_contents('Member.txt');
    $members = explode("\n",$user);
    if (!in_array($chat_id,$members)){
      $add_user = file_get_contents('Member.txt');
      $add_user .= $chat_id."\n";
     file_put_contents('Member.txt',$add_user);
    }
//@Roonx_Team
	?>
	
	
	///فال
