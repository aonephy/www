<?php
	header("content-Type: text/html; charset=utf-8");
	header('Content-type: text/json');
	include("../../conf/conn.php");
	$user=$_SESSION['user'];
	$user_id=$_SESSION['user_id'];
	$table = "musicLibrary";
	
	$libId = $_POST['libId'];
	$musicId = $_POST['musicId'];
	$ip = $_SERVER['REMOTE_ADDR'];
	
	if(!empty($user)){
		$qry = mysql_fetch_assoc(mysql_query("select id from $table where libId='$libId' and musicId='$musicId' and delstatus='1'"));
		if(empty($qry)){
			mysql_query("insert into $table (libId,musicId,ip,datetime) values ('$libId','$musicId','$ip',now())") or die(mysql_error());
			
			$out = array(
				'code'=>'10000',
				'data'=>array(
						'libId'=>$libId,
						'musicId'=>$musicId,
				)
			);
		}else{
			$out = array(
				'code'=>'10002',
				'data'=>array(
						'libId'=>$libId,
						'musicId'=>$musicId,
						
				),
				'msg'=>'歌曲已经在歌单中！'
			);
		}
	}else{
		$out = array(
			'code'=>'10001',
			'msg'=>'author error.'
		);
	}
	echo json_encode($out,JSON_UNESCAPED_UNICODE);
	
	
?>