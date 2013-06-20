<?php

require_once("/var/www/html/movie/libs/Format.class.php");

class FormatTest extends PHPUnit_Framework_TestCase {
	public function setUp() {
            $this->_format = new Format();
        }
	/**
	*    @dataProvider formatProvider
	*/
	public function testEncode($expect_flag, $str) {
	    $this->assertSame($expect_flag, $this->_format->encode($str));
	}

	public function formatProvider() {
	    $format_list = array();
	    $format_list[] = array(false, null);
	    $format_list[] = array("&quot;hoge&quot;", '"hoge"');
	    $format_list[] = array(false, array());
	    $format_list[] = array(false, true);
	    return $format_list;
	}
}
