<?php
	header("content-Type: text/html; charset=utf-8");
	header('Content-type: text/json');
	include("../../conf/conn.php");
	$user=$_SESSION['user'];
	$user_id=$_SESSION['user_id'];
	$table = "music";
	@$page = $_GET['page'];
	@$pagesize = $_GET['pagesize'];

	if(empty($page)) $page = 1;
	
	if(empty($pagesize)) $pagesize = 10;
	$pagebegin=($page-1)*$pagesize;

	$qry = mysql_query("select $table.title,$table.id,$table.audioUrl,$table.imageUrl,$table.author,$table.datetime,user.username from $table inner join user on $table.ownerid = user.id and $table.ownerid='$user_id' and delstatus='1' order by $table.id desc limit $pagebegin,$pagesize");
	$num = mysql_num_rows(mysql_query("select * from $table where ownerid='$user_id' and delstatus='1'"));
	
	$pageTotalNum=ceil($num/$pagesize);
	
	while($rs = mysql_fetch_assoc($qry)){
		$data[] = $rs; 
	}
	if(!empty($user)&&!empty($data)){
		$out = array(
			"code"=>'10000',
			'msg'=>'get data success',
			'totalPage'=>$pageTotalNum,
			'pageIndex'=>$page,
			'pageSize'=>$pagesize,
			'data'=>$data
		);
	}else{
		$out = array(
			'code'=>'10001',
			'msg'=>'author error.'
		);
	}
    
	echo json_encode($out,JSON_UNESCAPED_UNICODE);
?>

