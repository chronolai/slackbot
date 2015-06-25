<?php
include "slackbot.php";

define('TOKEN', 'your_token');

$slackbot = new Slackbot($_REQUEST);

$slackbot->valid('token', TOKEN, false);
$slackbot->valid('user_id', 'USLACKBOT');
$slackbot->valid('user_name', 'slackbot');
$slackbot->valid('text', '');

$slackbot->resp('天氣|氣象', function($data){
	$data['username'] = '氣象主播 - 刃利魚';

	$xml = simplexml_load_file("http://opendata.cwb.gov.tw/opendataapi?dataid=F-C0032-009&authorizationkey=CWB-E1DBB1C2-0A6A-4EB0-9BE6-358053080C85");
	if (false === $xml) {
		return;
	}
	$data['text'] = "";
	$data['text'] .= $xml->dataset->location->locationName."\n";
	foreach ($xml->dataset->parameterSet->parameter as $param) {
		$data['text'] .= $param->parameterValue."\n";
	}
	return $data;
});

$slackbot->resp('吃啥|吃什麼|肚子餓|午餐', function($data){
	$data['username'] = '食戟のソーマ - 幸平 創真';
	$restaurants = [
		"京讚",
		"京站",
		"珍珍水餃, 還可以買甜甜圈",
		"八方",
		"采岩堂",
		"日本人咖哩",
		"炒飯  (記得訂位 - 02 2521 6619 ^.<)",
		"新東陽",
		"新光三越",
		"永井壽司",
		"排骨酥",
		"摩斯",
		"王家漢堡"
	];
	$data["text"] = "吃".$restaurants[rand()%count($restaurants)];
	return $data;
});

$slackbot->resp('喝啥|喝什麼|飲料|口渴', function($data){
	$data['username'] = '飲料達人';
	$drinks = [
		"50嵐",
		"康青龍",
		"水巷茶弄",
		"星巴克",
		"冰箱的飲料",
		"水"
	];
	$data["text"] = "喝".$drinks[rand()%count($drinks)];
	return $data;
});

$slackbot->run();
