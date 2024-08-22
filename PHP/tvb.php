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
$clientIP = $_SERVER['REMOTE_ADDR'];

// 检查是否同时有IPv4和IPv6地址
if (strpos($clientIP, ',') !== false) {
    // 同时有IPv4和IPv6地址,分离出来
    $ipList = explode(',', $clientIP);
    $ipv6 = trim($ipList[0]); // 取第一个IP(IPv6)
    $ipv4 = trim($ipList[1]); // 取第二个IP(IPv4)

    // 优先使用IPv6
    $ip = $ipv6;
} elseif (filter_var($clientIP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
    // 只有IPv6地址
    $ip = $clientIP;
} else {
    // 只有IPv4地址 
    $ip = $clientIP;
}

$headers = array(
    'User-Agent: Dart/2.19 (dart:io)',
    'Content-Type: application/json',
    'Accept-Encoding: gzip',
    'Host: inews-api.tvb.com', 
    'CLIENT-IP: '.$ip,
    'X-FORWARDED-FOR: '.$ip
);

// 其他代码保持不变
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,'https://inews-api.tvb.com/news/checkout/live/hd/ott_'.$ids[$id].'_h264?profile=safari');
curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
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
