<?php
class Slackbot
{
	function __construct($req)
	{
		$this->req = $req;
		$this->list = [];
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
			$this->data[] = call_user_func_array($callback, [$this->data]);
		}
	}
	public function run()
	{
		$data = [];
		if (0 == count($this->data)) {
			$data['username'] = $this->data[0]['username'];
			$data['text'] = $this->data[0]['text'];
		} else {
			for ($i=0; $i < count($this->data); $i++) {
				$username = $this->data[$i]['username'];
				$text = $this->data[$i]['text'];
				@$data['text'] .= ($i>0?"\n----\n":'').$username.":\n".$text;
			}
		}
		echo json_encode($data);
	}
	public function getList($name)
	{
		return $this->list[$name];
	}
	public function setList($name, $list)
	{
		$this->list[$name] = $list;
	}
	public function getRandListItem($name)
	{
		$rand_key = array_rand($this->list[$name]);
		return $this->list[$name][$rand_key];
	}
}
