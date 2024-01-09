<?php
$token = '6281601464:AAGG46HfGlBUAJTeojKFg3QIXB0XBm65y5I'; //Insert telegram api bot token!
$update = json_decode(file_get_contents('php://input'), TRUE);
$msg = $update['message']['text'];
$userid = $update['message']['chat']['id'];
if(preg_match('/^\/([sS]tart)/',$msg)){ sendMessage($userid, "Hello!\n We can get live cricket score for you. \n Just send /live and we will get result for you."); //Welcome
}
if(preg_match('/^\/([lL]ive)/',$msg)){ 
    
    $result = file_get_contents("/getScore");
    $score = json_decode($result);
    if($score->success != 'true'){
        sendMessage($userid, "Something is wrong with our end.");
    }else{
    sendMessage($userid, $score->livescore->score);
    }
}

function sendMessage($chat_id, $text) { //function sendMessage
global $token;
    $args = ['chat_id' => $chat_id, 'parse_mode' => 'HTML', 'text' => $text, 'disable_web_page_preview' => '1'];
    return cURL('https://api.telegram.org/bot'.$token.'/sendMessage', $args);
    }
function cURL($url, $args='') { //function curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        $output = curl_exec($ch);
        return $output;
        curl_close($ch);
    }
    
    ?>
