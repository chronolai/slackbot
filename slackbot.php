<?php
class Slackbot
{
	function __construct($req)
	{
		$this->req = $req;
		$this->data = [];
	}
	public function debug($value='')
	{
		echo "<pre>" . print_r($value, 1) . "</pre>";
	}
	public function valid($key, $value, $cond = true)
	{
		if (($this->req[$key] === $value) === $cond) {
			exit();
		}
	}
	public function resp($keyword, $callback)
	{
		if (preg_match("/" . $keyword . "/", $this->req['text'], $args)) {
			$this->data[] = call_user_func_array($callback, [$data]);
		}
	}
	public function run()
	{
		$data = [];
		for ($i=0; $i < count($this->data); $i++) { 
			$data['username'] .= ($i>0?', ':'').$this->data[$i]['username'];
			$data['text'] .= ($i>0?"\n----\n":'').$this->data[$i]['text'];
		}
		echo json_encode($data);
	}
}