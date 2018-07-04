<?php
	header("content-Type: text/html; charset=utf-8");
	header('Content-type: text/json');
	include("../../conf/conn.php");
	$user=$_SESSION['user'];
	$user_id=$_SESSION['user_id'];
	$table = "musicLibraryList";

	$qry = mysql_query("select libId,libName from $table where ownerid='$user_id' and delstatus='1'");
	
	
	while($rs = mysql_fetch_assoc($qry)){
		$tmp[] = $rs; 
	}
	if(!empty($user)&&!empty($tmp)){
		$out = array(
			"code"=>'10000',
			'msg'=>'get data success',
			'data'=>$tmp
		);
	}else{
		$out = array(
			'code'=>'10001',
			'msg'=>'author error.'
		);
	}
    
	echo json_encode($out,JSON_UNESCAPED_UNICODE);
?>

