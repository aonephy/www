<head>
	<style>
	input{    width: 300px;    height: 30px;    padding: 3px;}
	</style>
</head>
<?php
	include('simple_html_dom.php');
	
	$turl = "lianyun.fc10010.com";
	
	@$turl = $_GET['u'];
	@$d = $_GET['d'];
	
	$tt = "#HttpOnly_".$turl."	FALSE	/	FALSE	0	JSESSIONID	".$d."\r\n";
	
	file_put_contents("cookie-.txt",$tt);

	//wait 2 seconds
	sleep(2);
	
	$url = "https://".$turl."/system/payment_list.php";

	$queryRightUrl = "https://".$turl."/userlevel/user_recharge_permissions.php";

	
	
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
	
	function filter($content){
		$html = new simple_html_dom();
		$html->load($content);
		foreach($html->find('#myTabData td') as $aList){
		//	print_r($aList->onclick);
			$arr[] = $aList->innertext;
			echo $aList->innertext;
			if(strstr($aList->onclick,'change')){
				$arr_change[] = $aList->onclick;
			}	
			if(strstr($aList->onclick,'querySecond')){
				$arr_querySecond[] = $aList->onclick;
			}
		
		}
		 $arr=array(
			'change'=>$arr_change,
			'querySecond'=>$arr_querySecond,
		 );
		
		return $arr;
	}

	function filter_2($content){
		$html = new simple_html_dom();
		$html->load($content);
		
		foreach($html->find('#myTabData td') as $aList){
			$t_arr[] = $aList->innertext;
			
		}
		$j = 0;
		$i = 0;
		foreach($t_arr as $key => $value ){
			
			$arr[$j][$i] = $value;
			$i++;
			
			if($i==12){
				$i=0;
				$j++;
			}
		}
		return $arr;
	}
	
	function filter_3($content){
		$html = new simple_html_dom();
		$html->load($content);
		
		foreach($html->find('#myTabData td') as $aList){
			$t_arr[] = $aList->innertext;
			
		}
		
		$j = 0;
		$i = 0;
		
		foreach($t_arr as $key => $value ){
			
			$arr[$j][$i] = $value;
			$i++;
			
			if($i==11){
				$i=0;
				$j++;
			}
		}
		return $arr;
	}
	
	
	
	function queryLevel2($type,$n){
		global $turl;
		$url = "https://".$turl."/system/payment_second_list.php?pay_type=".$type;
		$cc = get_data($url);
		$out = filter_2($cc);
		@$txt = file_get_contents("output/".$turl."_level_2.txt");
		
		foreach($out as $key => $val){
			$txt .= $n.'|'.$val[4].'|'.$val[1].'|'.$val[2].'|'.$val[10]."\r\n";
		}
		file_put_contents("output/".$turl."_level_2.txt",$txt);
	}
	
	function filterLevel2(){
		for($i=0;$i<count($list);$i++){
			$urll = $url.$list[$i];
			dd($i,$urll);
		}
	}
	
	//写入txt记事本  
	function Level1toText($arr){
		global $turl;
		$n=1;
		$txt ="";
		foreach($arr as $key => $val){
			$txt .= ($n)."|".$val[1]."|".$val[9]."\r\n";
			
			if($val[9]=="全部开启")
				Level2toText($val[10],$n);
			$n++;
		}
		file_put_contents("output/".$turl."_level_1.txt",$txt);
		
		echo "<br>";
		echo "一级支付开启情况，success...   <a href='output/".$turl."_level_1.txt'>level 1</a><br>";
		
	}
	
	function Level2toText($content,$n){
		global $turl;
		$html = new simple_html_dom();
		$html->load($content);
		
		foreach($html->find('button') as $aList){
			$rs = $aList->onclick;
		}
		if(strstr($rs,"querySecond")){
			$out = str_replace("')","",str_replace("querySecond('","",$rs));
			echo $n.'->'.$out."<br>";
			queryLevel2($out,$n);
		}
		echo "二级支付开启情况，success...   <a href='output/".$turl."_level_2.txt'>level 2</a><br>";
	}

//-----------------------------------------------------------------
	
// start
if($turl==''||$d==''){
?>
	<form method='get' >
		<input type='text' name='u' placeholder='请输入域名...不包含http://'>
		<input type='text' name='d' placeholder='请输入JSESSIONID'>
		<input type='submit' name='submit' value='submit'>
	</form>
<?php	
}else{
	echo "start...   <a href='3.php'>添加其它</a><br>";
	echo $url.'<br><p>';
	$out = filter_3(get_data($url));
	
	Level1toText($out);
}	
?>