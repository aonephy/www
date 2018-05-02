
<?php
	$url = 'http://aonephy.top/ip/?ip=140.205.9.51';
	function get_data($url){
		$cookie_file = dirname(__FILE__) . '\cookie-.txt'; 
		$curl = curl_init();
		$timeout = 50;
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);  // 从证书中检查SSL加密算法是否存在
	    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);
		$rs = curl_exec($curl);
		curl_close($curl);
		
		return $rs;
	}
	
	echo get_data($url);
?>