<?php
class TimesheetPager{
	
	private $controls,$body;
	
	function getPage($page){
		$this->controls 	= $this->getFile('controls/'.$page.'.php');
		$this->body 		= $this->getFile('pages/'.$page.'.php');
	}
	
	function getFile($file) {
		ob_start();
		if(file_exists($file)){
			include_once $file;
		}
		return ob_get_clean();
	}
	public function getJson() {
		$page = new stdClass();
		$page->controls = $this->controls;
		$page->body = $this->body;
		return json_encode($page);
	}
}