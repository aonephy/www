<?php
	include('simple_html_dom.php');
	error_reporting(E_ALL & ~E_NOTICE);
	
	$uid = $_GET['uid'];
	$cookie = dirname(__FILE__) . '/cookie.txt'; 
	$cookie = tempnam('./temp','cookie'); 
	
	$agent = "Mozilla/5.0 (Linux; U; Android 4.1.2; zh-cn; GT-I9300 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30 MicroMessenger/5.2.380";
	$agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11";
	//模拟登录 
	function login_post($url, $post) { 
		global $cookie; 
		global $agent;
			
		$curl = curl_init();//初始化curl模块 
		curl_setopt($curl, CURLOPT_URL, $url);//登录提交的地址 
		curl_setopt($curl, CURLOPT_HEADER, 0);//是否显示头信息
		curl_setopt($curl, CURLOPT_USERAGENT, $agent);  
	//	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	//	curl_setopt($curl, CURLOPT_MAXREDIRS, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);//是否自动显示返回的信息 
		curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); //设置Cookie信息保存在指定的文件中 
		curl_setopt($curl, CURLOPT_POST, 1);//post方式提交 
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));//要提交的信息 
		curl_exec($curl);//执行cURL 
		curl_close($curl);//关闭cURL资源，并且释放系统资源 

	} 
	//登录成功后获取数据 
	function get_content($url) {
		global $cookie; 
		global $agent; 
		
		
	    $ch = curl_init(); 
	    curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_USERAGENT, $agent); 
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  // 从证书中检查SSL加密算法是否存在
	    curl_setopt($ch, CURLOPT_HEADER, 0); 
	//	curl_setopt($ch, CURLOPT_REFERER, "http://wpi.renren.com/ajaxproxy.htm"); 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	//	curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:111.222.333.4', 'CLIENT-IP:111.222.333.4'));  
	    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie); //读取cookie 
	    $rs = curl_exec($ch); //执行cURL抓取页面内容 
	    curl_close($ch); 

		return $rs;
	    $out = relative_to_absolute($rs,$url); 
		  
	    return $out;
	} 
	
	//相对路径转绝对路径方法：
	function relative_to_absolute($content, $feed_url) {
	    preg_match('/(http|https|ftp):\/\//', $feed_url, $protocol);
	    	    
	    $server_url = preg_replace("/(http|https|ftp|news):\/\//", "", $feed_url);
	    $server_url = preg_replace("/\/.*/", "", $server_url);

	    if ($server_url == '') {
	        return $content;
	    }
	
	    if (isset($protocol[0])) {
	        $new_content = preg_replace('/href="\//', 'href="'.$protocol[0].$server_url.'/', $content);
	        $new_content = preg_replace('/src="\//', 'src="'.$protocol[0].$server_url.'/', $new_content);
	        $new_content = preg_replace('/href="..\/..\//', 'href="'.$protocol[0].$server_url.'/', $new_content);
//	        $new_content = preg_replace('/rr?', 'src="'.$protocol[0].$server_url.'/rr?', $new_content);
	        
//	        $new_content = preg_replace('/href="\//', 'href="https://', $content);
//	        $new_content = preg_replace('/src="\//', 'src="https://', $new_content);
	    } else {
	        $new_content = $content;
	    }
	
	    return $new_content;
	}
	
	function filter_content($content){
		
	    $postb = strpos($content,"news-box\">")+10;
		$poste = strpos($content,"ul>");
		$length = $poste - $postb - 163;

	//	return substr($content,$postb,$length);

		$preg = '/<li><a href=\"(.*)\" namecard/i'; 
		preg_match_all($preg, $content, $arr); 

		$str = $arr[1];
		return $str;
	}
	function filter_url($content){
		$html = new simple_html_dom();
		$html->load($content);
		foreach($html->find('.share-friend ul a') as $aList){
			$arr[] = $aList->href;
		}
		 
		return $arr;
	}
	//爬去内容
	function getData($url){
		$content = get_content($url);
		$html = new simple_html_dom();
		$html->load($content);
		
		$name = mb_substr($html->find('.b_2',0)->innertext,6);		
		$img = $html->find('#userpic',0)->src;
		
		$arr = array(
			'img'=>$img,
			'name'=>$name,
		);
		
		return $arr;
	}
	function saveData($arr){
		global $table; 

		if(!empty($arr['name'])&&$arr['name']!="抱歉，没有找到该网页"){
			$sql = "insert into $table (name,url,school,work,gender,birthday,hometown,address,img) values ('$arr[name]','$arr[url]','$arr[school]','$arr[work]','$arr[gender]','$arr[birthday]','$arr[hometown]','$arr[address]','$arr[img]')";
			mysql_query($sql) or die(mysql_error());
		}
	}

	//基于url爬取符合renren的url
	function get_url($url){
		$out = get_content($url);
		
		$tmpUrl = filter_url($out);
		return $tmpUrl;
	}
	/*
	*去重数据
	*/
	
	function quchong($arr){
		return array_merge(array_unique($arr));
	}

	
	$url = "http://www.fctest.com/system/payment_list.php";
//	$url = "http://www.fctest.com/system/payment_second_list.php?pay_type=DINPAYQR";
	

//	$out = relative_to_absolute(file_get_contents($url2),$url2);

	echo "initial...\n\r";
//	echo $url;
//	print_R( getData($url));
	echo  file_get_contents($url);

//	print_r($urlList);
	
?>