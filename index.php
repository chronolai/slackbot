<?php
include "config.php";
include "slackbot.php";

$slackbot = new Slackbot(BOT_NAME, $_REQUEST);

$slackbot->valid('token', TOKEN, false);
$slackbot->valid('user_id', 'USLACKBOT');
$slackbot->valid('user_name', 'slackbot');
$slackbot->valid('text', '');

$slackbot->setList('test', [
	"測尛? 我還沒死...",
	"當機我就不會回你了阿!!!",
]);

$slackbot->add('test|測試', function() use($slackbot) {
	$data['username'] = 'robot';
	$data['text'] = $slackbot->getRandListItem('test');
	return $data;
});

$slackbot->add('叫(?<times>\d+)聲', function($times) {
	$data['username'] = 'robot-cat';
	$data['text'] = str_repeat("Meow! ", $times);
	return $data;
});

$slackbot->run();
