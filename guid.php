<?php
class cGuid{
	public function create_guid(){
		$charid = strtoupper(md5(uniqid(mt_rand(), true)));
		$hyphen = chr(45);// "-"
		$uuid = substr($charid, 6, 2).substr($charid, 4, 2).
		substr($charid, 2, 2).substr($charid, 0, 2).$hyphen
		.substr($charid, 10, 2).substr($charid, 8, 2).$hyphen
		.substr($charid,14, 2).substr($charid,12, 2).$hyphen
		.substr($charid,16, 4).$hyphen.substr($charid,20,12);
		return $uuid;
	}
}
	$obj = new cGuid(); 
	echo $obj->create_guid();
	
?>