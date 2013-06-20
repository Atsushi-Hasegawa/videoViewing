<?php

class Format {
    public function encode($str) {
        return (@is_array($str) || empty($str) || is_string($str) === false)
                 ? false
                 : htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
	}

}
