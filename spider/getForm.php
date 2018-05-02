<?php

	include('simple_html_dom.php');
	$url = "http://www.fctest.com/report/report_005.php";
	
	function get_data($url){
		$post_data = array(
			"pageCount" => $_GET['pageCount'],
			"start_date" => $_GET['start_date'],
			"end_date" => $_GET['end_date']
		);
		
		
		$cookie_file = dirname(__FILE__) . '\cookie-.txt'; 
		$curl = curl_init();
		$timeout = 50;
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);  // 从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
	    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);
		$rs = curl_exec($curl);
		curl_close($curl);
		
		return $rs;
	}
	
	function filter($content){
		$html = new simple_html_dom();
		$html->load($content);
		$out = $html->find('#myTabData',0);
		return $out;
	}
	
	if(@$_GET['start_date']==''||$_GET['end_date']==''||$_GET['pageCount']==''){
	?>
	<form method='get' >
		<input type='text' name='start_date' placeholder='开始日期' value='20170101'>
		<input type='text' name='end_date' placeholder='结束日期' value='20180409'>
		<input type='text' name='pageCount' placeholder='显示数据量，建议2000' >
		<input type='submit' name='submit' value='submit'>
	</form>
<?php
	}else{
		echo filter(get_data($url));
	}
?>

<script src='/js/jquery-1.11.3.min.js'></script>

<script>
	/*
	$.ajax({
		url:'http://www.fctest.com/report/report_005.php',
		dataType:'html',
		success:function(rs){
		//	console.log(rs)
		}
	})
*/
</script>