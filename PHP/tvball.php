<?php
/*
    GeJI 恩山论坛
    *DIYP支持版↓
    .php?id=0&normal=1 翡翠台
    .php?id=1&normal=1 J2
    .php?id=2&normal=1 無線新聞台576P
    .php?id=4&normal=1 無線新聞台·海外版
    .php?id=6&normal=1 無線財經體育資訊台·海外版
    .php?id=8&normal=1 事件直播頻道1
    .php?id=10&normal=1 事件直播頻道2
    *DIYP支持版↑
    .php?id=0 翡翠台
    .php?id=1 J2
    .php?id=2 無線新聞台
    .php?id=3 無線新聞台576P
    .php?id=4 無線新聞台·海外版
    .php?id=5 無線新聞台·海外版360P
    .php?id=6 無線財經體育資訊台·海外版
    .php?id=7 無線財經體育資訊台·海外版360P
    .php?id=8 事件直播頻道1
    .php?id=9 事件直播頻道1 360P
    .php?id=10 事件直播頻道2
    .php?id=11 事件直播頻道2 360P
*/
$id = $_GET['id'];
$ids = ['I-J','I-J2','C','C','I-NEWS','I-NEWS','I-FINA','I-FINA','NEVT1','NEVT1','NEVT2','NEVT2'];
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
if($id == '3' || $id == '5' ||$id == '7' || $id == '9' || $id == '11' || $id == '13') {
    header('location:'.$url->sd);
} else {
    if($id == '0' || $id == '1' || $id == '2' || $id == '4' || $id == '6' || $id == '8' || $id == '10') {
        if($_GET['normal']) {
            $r = preg_replace('/&p=(.*?)$/','',$url->hd);
            $r = $r.'&p=3000';
            header('location:'.$r);
            exit();
        };
        $r = preg_replace('/&p=(.*?)$/','',$url->hd);
        header('location:'.$r);
        exit();
    };
    header('location:'.$url->hd);
};