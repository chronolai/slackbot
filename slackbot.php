<?php
class Slackbot
{
	function __construct($name, $input)
	{
		$this->name = $name;
		$this->input = $input;
		$this->list = [];
		$this->data = [];
	}
	public function debug($value='')
	{
		echo "<pre>" . print_r($value, 1) . "</pre>";
	}
	public function valid($key, $value, $cond = true)
	{
		if (($this->input[$key] === $value) === $cond) {
			exit();
		}
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
	public function add($keyword, $callback)
	{
		$this->rules["/" . $keyword . "/"] = $callback;
		return $this;
	}
	public function run()
	{
		foreach ($this->rules as $rule => $callback) {
			$args = [];
			if (preg_match($rule, $this->input['text'], $args)) {
				// remove int index
				foreach ($args as $key => $value) {
					if (is_numeric($key)) {
						unset($args[$key]);
					}
				}
				// end
				$this->data[] = call_user_func_array($callback, $args);
			}
		}
		$resp= ['username'=>$this->name];
		for ($i=0; $i < count($this->data); $i++) {
			$username = @$this->data[$i]['username'];
			$text = @$this->data[$i]['text'];
			@$resp['text'] .= ($i>0?"\n----\n":'').$username.":\n".$text;
		}
		echo json_encode($resp);
	}
}
