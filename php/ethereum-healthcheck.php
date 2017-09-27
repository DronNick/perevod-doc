<?php

//echo("OK");

//echo phpinfo();

function getJSON($url){
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,$url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'PHP');
        $query = curl_exec($curl_handle);
        curl_close($curl_handle);
        return json_decode($query);
}

$data = getJSON("https://api.nanopool.org/v1/eth/avghashrate/0x2e9a1c0232d121f0c7a5c2493d7d6ace1eaae84b/Radeon_R9_280x");

//var_dump($data);

//echo "3h  av. hashrate  = ".$data->data->h3." MH/s";
//echo ("\n");

if(floatval($data->data->h3)>9) die();

$text = "Mining Speed Low: ".$data->data->h3."MH/s last 3h.";

$botToken = "340504412:AAG8xHpW_ffX2aHFKzHpYgf2TR7aH1SthNw";
$website="https://api.telegram.org/bot".$botToken;
$chatID=12051511;
$params=array('chat_id'=>$chatID,'text'=>$text);

$ch = curl_init($website . '/sendMessage');
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close($ch);

//echo("\n");
//var_dump($result);

//$update = file_get_contents($website."/getupdates");
//print_r($update);
