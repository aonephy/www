<?php
	header("content-Type: text/html; charset=utf-8");
//	header('Content-type: text/json');
	include("../../bbs/conn.php");
	$user=$_SESSION['user'];
	$user_id=$_SESSION['user_id'];
	$table = "musicLibraryList";
	
	$libraryName = $_POST['libraryName'];
	$ip = $_SERVER['REMOTE_ADDR'];
	
	if(!empty($user)){
		$libId = time().rand(100,999);
		mysql_query("insert into $table (libId,libName,ownerId,ip,datetime) values ('$libId','$libraryName','$user_id','$ip',now())") or die(mysql_error());
		
		$out = array(
			'code'=>'10000',
			'data'=>array(
					'libId'=>$libId,
					'libName'=>$libraryName
			)
		);
	}else{
		$out = array(
			'code'=>'10001',
			'msg'=>'author error.'
		);
	}
	echo json_encode($out,JSON_UNESCAPED_UNICODE);
	
	
?>