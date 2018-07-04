<?php
	header("content-Type: text/html; charset=utf-8");
	header('Content-type: text/json');
	include("../../conf/conn.php");
	$user=$_SESSION['user'];
	$table = "music";
	
	$ip = $_SERVER['REMOTE_ADDR'];
	
	
	if(!empty($user)){
		
		$audioUrl = "http://live.zb.huaweils.com/".$_POST['fileName'];

		mysql_query("insert into $table (title,audioUrl,author,ownerid,ip,datetime) values ('$_POST[musicName]','$audioUrl','$_POST[musicAuthor]','$_POST[ownerId]','$ip',now())") or die(mysql_error());
		
		$out = array(
			"code"=>'10000',
			'msg'=>'get data success'
		);
		}else{
			$out = array(
				'code'=>'10001',
				'msg'=>'author error.'
			);
		}
	$out = $_POST;
    
	echo json_encode($out,JSON_UNESCAPED_UNICODE);
?>

