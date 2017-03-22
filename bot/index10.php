<?php
ob_start();
//@Worldtm
define('API_KEY','**TOKEN**');
$admin =  "**ADMIN**";
$update = json_decode(file_get_contents('php://input'));
$firstname = $update->message->firstname;
$fname = $update->callback_query->message->firstname;
$from_id = $update->message->from->id;
$chat_id = $update->message->chat->id;
$chatid = $update->callback_query->message->chat->id;
$data = $update->callback_query->data;
$text = $update->message->text;
$message_id = $update->callback_query->message->message_id;
$message_id_feed = $update->message->message_id;
$love = file_get_contents("http://api.roonx.com/textlove/");
function ehsan($method,$datas=[]){
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
ehsan('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"سلام `$firstname`\nبه ربات عاشقانه خوش اومدي🖤\nميتوني اين متن هارو برايه كسايي كه دوست داري بفرستي\n@Worldtm",
    'parse_mode'=>'html',
   'reply_markup'=>json_encode([
      'inline_keyboard'=>[
          [
     ['text'=>'دريافت يك متن عاشقانه😻🍃','callback_data'=>'love']
          ]
        ]
		])
  ]);
}elseif(preg_match('/^\/([Ll]ove)/',$text)){
ehsan('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>$love,
    'parse_mode'=>'html'
  ]);
}
elseif ($data == "love") {
  ehsan('editMessagetext',[
    'chat_id'=>$chatid,
	'message_id'=>$message_id,
    'text'=>$love,
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
      'inline_keyboard'=>[
        [
          ['text'=>'دوباره🍃','callback_data'=>'love']
        ],
	  [
		['text'=>'برگردیم🔙','callback_data'=>'menu']
      ]
      ]
    ])
  ]);
 }
elseif ($data == "menu") {
  ehsan('editMessagetext',[
    'chat_id'=>$chatid,
	'message_id'=>$message_id,
    'text'=>"سلام `$fname`عزيز\nبه ربات عاشقانه خوش اومدي🖤\nميتوني اين متن هارو برايه كسايي كه دوست داري بفرستي\n@Worldtm",
    'parse_mode'=>'html',
   'reply_markup'=>json_encode([
      'inline_keyboard'=>[
          [
     ['text'=>'دريافت يك متن عاشقانه😻🍃','callback_data'=>'love']
          ]
      ]
    ])
  ]);
 }
elseif(preg_match('/^\/([Ss]tats)/',$text) and $from_id == $admin){
    $user = file_get_contents('Member.txt');
    $member_id = explode("\n",$user);
    $member_count = count($member_id) -1;
    ehsan('sendMessage',[
      'chat_id'=>$chat_id,
      'text'=>"امار ربات شما: $member_count",
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
//@Ariyan_mor
	?>
