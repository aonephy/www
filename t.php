<?php
	header("content-type:text/html;charset=utf-8");
	include('/config/conn.php');
	include("http://aonephy.top/bbs/conn.php");
	$sql = mysql_query("select * from test");
	while($rs = mysql_fetch_array($sql)){
	//	echo json_encode($rs);
		
		echo $rs['id'].'--->'.$rs['content']."\r\n";
		
	}
	
?>