<?php

class Format {
	//セキュリティ
	public function h($str) {
		$str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
		return $str;
	}

}
