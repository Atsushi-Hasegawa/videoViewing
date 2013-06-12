<?php

require_once(ROOT_DIR.'/libs/Smarty.class.php');
class MySmarty extends Smarty{
	function MySmarty(){
		$this->template_dir= ROOT_DIR."/templates";
		$this->compile_dir= ROOT_DIR."/templates_c";
		$this->cache_dir= ROOT_DIR."/cache";
		$this->left_delimiter  = "{{";
		$this->right_delimiter = "}}";
		$this->plugins_dir     = array("plugins", "myplugins");
		$this->Smarty(); 
		//parent::__construct();
	}
}
