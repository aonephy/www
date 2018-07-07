<?php
	header("content-Type: text/html; charset=utf-8");
//	header('Content-type: text/json');
	include("../../conf/conn.php");
	$user=$_SESSION['user'];
	$user_id=$_SESSION['user_id'];
	$table = "musicLibraryList";

	$qryLibrary = mysql_query("select libId,libName from $table where ownerid='$user_id' and delstatus='1'");
	
	
	while($rs = mysql_fetch_assoc($qryLibrary)){
		
		$libId = $rs['libId'];
		$qryMusic = mysql_query("select musicLibrary.libId,musicLibrary.musicId,music.title,music.author,music.audioUrl from musicLibrary inner join music on musicLibrary.musicId = music.id where musicLibrary.libId='$libId' and musicLibrary.delstatus='1'");
		$rs['musicList']=[];
		while($libMusic = mysql_fetch_assoc($qryMusic)){
			
			array_push($rs['musicList'], $libMusic);
		}
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
				'msg'=>'暂无歌单！',
				'libId'=>$libId
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

