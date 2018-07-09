<?php
	header("content-Type: text/html; charset=utf-8");
	header('Content-type: text/json');
	include("../../bbs/conn.php");
	$user=$_SESSION['user'];
	$user_id=$_SESSION['user_id'];
	$table = "music";
	
	$qry = mysql_query("select id,title,audioUrl,imageUrl,author from $table where (ownerid='$user_id' or share='1') and delstatus='1' order by id");
	while($rs = mysql_fetch_assoc($qry)){
		$tmp[] = $rs;
	}
	
	if(!empty($user)&&!empty($tmp)){
		$out = array(
			'code'=>'10000',
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