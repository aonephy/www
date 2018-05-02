<?php
/**
 * 模拟登录
 */
  
//初始化变量
$cookie_file = dirname(__FILE__) . '/cookie.txt'; 
$login_url = "http://www.fctest.com/backoffice/userLoginAction.php";
$verify_code_url = "http://www.fctest.com/public/attachImage.php";
$url = "http://www.fctest.com/system/payment_list.php";


echo "正在获取COOKIE...\n<br>";

$curl = curl_init();
$timeout = 5;
curl_setopt($curl, CURLOPT_URL, $login_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($curl,CURLOPT_COOKIEJAR,$cookie_file); //获取COOKIE并存储
$contents = curl_exec($curl);
curl_close($curl);

  
echo "COOKIE获取完成，正在取验证码...\n<br>";
//取出验证码
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $verify_code_url);
curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$img = curl_exec($curl);
curl_close($curl);
  
$fp = fopen("verifyCode.jpg","w");
fwrite($fp,$img);
fclose($fp);
echo "验证码取出完成，正在休眠，20秒内请把验证码填入code.txt并保存\n<br>";
//停止运行20秒
sleep(20);
  
echo "休眠完成，开始取验证码...\n<br>";
$code = file_get_contents("code.txt");
echo "验证码成功取出：$code\n<br>";
echo "正在准备模拟登录...\n<br>";
  
$post = "user_id=admin&password=a123456&page_type=1&login_page_name=LG_A&attach=$code&offsetHeight=886&offsetWidth=1920";

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
curl_setopt($curl,CURLOPT_COOKIEJAR,$cookie_file); //获取COOKIE并存储
//curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);
$result=curl_exec($curl);
curl_close($curl);
print_r($result);

//这一块根据自己抓包获取到的网站上的数据来做判断
if(substr_count($result,"登录成功")){
 echo "登录成功\n<br>";
}else{
 echo "登录失败\n<br>";
 exit;
}
  
//OK，开始做你想做的事吧。。。。。
?>