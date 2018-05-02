<?php
	include('simple_html_dom.php');
	
	$turl = "lianyun.fc10010.com";
	$url = "http://".$turl."/system/payment_list.php";
//	$url = "http://www.fctest.com/system/payment_second_list.php?pay_type=";
/*
	$list = array(
		'0' => 'SWIFTPASS',
		'1' => 'YUNBAO',
		'2' => 'QZF',
		'3' => 'DINPAYQR',
		'4' => 'CAIMAO',
		'5' => 'KFSHOP',
		'6' => 'QYF',
		'7' => 'QYFWAP',
		'8' => 'XLZF',
		'9' => 'PALMREST',
		'10' => 'GULA',
		'11' => 'YET',
		'12' => 'TJCXGQR',
		'13' => 'CHT',
		'14' => 'ZHF',
		'15' => 'DDBQR',
		'16' => 'XJTQR',
		'17' => 'YQZF',
		'18' => 'DDZFQR',
		'19' => 'CSZFQR',
		'20' => 'CSZFQP',
		'21' => 'JHJFQR',
		'22' => 'MSZFQR',
		'23' => 'GXTQR',
		'24' => 'YFZFQR',
		'25' => 'LANCHUANG',
		'26' => 'RFZFQR',
		'27' => 'YZF',
		'28' => 'SUBAO',
		'29' => 'TAOFU',
		'30' => 'SUILF',
		'31' => 'GUAGUA',
		'32' => 'QUANFT',
		'33' => 'HAOZF',
		'34' => 'MIAOFB',
		'35' => 'DABF',
		'36' => 'TJFZF',
		'37' => 'XINFQQZF',
		'38' => 'XINFZF',
		'39' => 'JUHE',
		'40' => 'LCZF',
		'41' => 'YITONG',
		'42' => 'HCZF',
		'43' => 'FCZF',
		'44' => 'HXZF',
		'45' => 'ZHIDIAN',
	);
	*/
	echo "正在获取...\n<br>";
	
	function get_data($url){
		$cookie_file = dirname(__FILE__) . '/cookie-.txt'; 
		$curl = curl_init();
		$timeout = 5;
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);
		$rs = curl_exec($curl);
		curl_close($curl);
		return $rs;
	}
	
	function filter($content){
		$html = new simple_html_dom();
		$html->load($content);
		foreach($html->find('tr button[onclick]') as $aList){
		//	print_r($aList->onclick);
		//	$arr[] = $aList->onclick;
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
		echo "...";
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
	
	
	
	function dd($n,$url){
		$cc = get_data($url);
		$out = filter_2($cc);
		
		foreach($out as $key => $val){
			echo ($n+1).'->'.$val[4].'->'.$val[1].'->'.$val[2].'->'.$val[6].'->'.$val[7].'->'.$val[8].'<br>';
		}
	}
	
	function filterLevel2(){
		for($i=0;$i<count($list);$i++){
			$urll = $url.$list[$i];
			dd($i,$urll);
		}
	}
	echo "cookie->JSESSIONID : ".$_COOKIE['JSESSIONID']."<br>\n";
	
//	echo get_data($url);
	
	$out = filter(get_data($url));
	print_r($out);


?>