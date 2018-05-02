<!Doctype html>
<html>
	<head>
		<style>
			body{word-break:break-all}
			input{    width: 300px;    height: 30px;    padding: 3px;}
		</style>
	</head>
	<body>
<?php
	@session_start();
	include('simple_html_dom.php');
	
//	$turl = "admin-api.sayahao.com/cash/3ths?page=1&page_size=10";
	@$tmp = explode('/',$_POST['u']);
	@$apiUrl = str_replace('admin','admin-api',$tmp[2]);
	@$turl = $apiUrl."/cash/3ths?page=1&page_size=1000";
	@$d = $_POST['d'];
	
	function get_data($url){
		$curl = curl_init();
		$timeout = 50;
		$token = $_POST['d'];
		$headers = array(
			"Authorization: Bearer $token",
		);
		
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_URL, $url);//登录提交的地址
		curl_setopt($curl, CURLOPT_HEADER, 0);//是否显示头信息
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//是否自动显示返回的信息
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);  // 从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
		
		$rs = curl_exec($curl);
		curl_close($curl);
		
		return $rs;
	}
	

	function toJson($content,$apiUrl){
		if(!empty($content)){
			$curTime = time();
		//	echo $content;
			file_put_contents("outjson/".$curTime."_".$apiUrl.".json",$content);
			echo "导出成功！";
		}else{
			echo "导出失败！";
		}
	}
	
	
	
// start
if($turl==''||$d==''){
?>
	<form method='post' >
		<input type='text' name='u' placeholder='请输入域名...不包含http://' value='<?=@$_POST['u']?>'>
		<input type='text' name='d' placeholder='请输入token' value='<?=@$_POST['d']?>'>
		<input type='submit' name='submit' value='submit'>
	</form>
<?php
}else{	
	echo "start...<br>";
	echo "接口地址：$apiUrl<br><br>";
	//wait 2 seconds
	sleep(2);
	
	$url = "http://".$turl;
	
//-----------------------------------------------------------------

	toJson(get_data($url),$apiUrl);
	echo "<br><br><a href='5.php'>重新获取</a>";
}
?>
	</body>
</html>