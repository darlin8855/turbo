<?php
/*
    .php?id=0&hq 無線新聞台1080P
    .php?id=0 無線新聞台720P
    .php?id=1 無線新聞台360P
    .php?id=2&hq 無線財經·體育·資訊台1080P
    .php?id=2 無線財經·體育·資訊台720P
    .php?id=3 無線財經·體育·資訊台360P
    .php?id=4&hq 事件直播頻道1 1080P（全清晰度）
    .php?id=4 事件直播頻道1 720P
    .php?id=5 事件直播頻道1 576P
    .php?id=6&hq 事件直播頻道2 1080P（全清晰度）
    .php?id=6 事件直播頻道2 720P
    .php?id=7 事件直播頻道2 576P
*/
$id = $_GET['id'];
$ids = ['I-NEWS','I-NEWS','I-FINA','I-FINA','NEVT1','NEVT1','NEVT2','NEVT2'];
$hq = $_GET['hq'];
if(!isset($ids[$id])) {
    exit();
};
$header[] = 'CLIENT-IP:127.0.0.1';
$header[] = 'X-FORWARDED-FOR:127.0.0.1';
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,'https://inews-api.tvb.com/news/checkout/live/hd/ott_'.$ids[$id].'_h264?profile=safari');
curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
$data = curl_exec($ch);
curl_close($ch);
$json = json_decode($data);
$url = $json->content->url;
if(isset($hq)) {
    if($id == '4' || $id == '5' || $id == '6' || $id == '7') {
        header('location:'.preg_replace('/&p=(.*?)$/','',$url->hd));
    } else {
        header('location:'.preg_replace('/&p=(.*?)$/','&p=3000',$url->hd));
    };
} else if($id == '0' || $id == '2' || $id == '4' || $id == '6') {
    header('location:'.$url->hd);
} else {
    header('location:'.$url->sd);
};
