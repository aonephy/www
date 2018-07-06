<?php
	header("content-Type: text/html; charset=utf-8");
	header('Content-type: text/json');
	include("../../conf/conn.php");
	$user=$_SESSION['user'];
	$table = "musicLibrary";
	$libId = $_POST['libId'];
	
	$qry = mysql_query("select $table.libId,$table.musicId,music.title,music.author,music.audioUrl from $table inner join music on $table.musicId = music.id where $table.libId='$libId' and $table.delstatus='1'");
	
	
	while($rs = mysql_fetch_assoc($qry)){
		$tmp[] = $rs; 
	}
	if(!empty($user)){
		
		if(!empty($tmp)){
			$out = array(
				"code"=>'10000',
				'msg'=>'get data success',
				'data'=>$tmp
			);
		}else{
			$out = array(
				'code'=>'10002',
				'msg'=>'该歌单暂无无音乐，请添加歌曲到您的歌单！',
				'libId'=>$libId
			);
		}
	}else{
		$out = array(
			'code'=>'10001',
			'msg'=>'author error.',
			'libId'=>$libId
		);
	}
    
	echo json_encode($out,JSON_UNESCAPED_UNICODE);
?>

