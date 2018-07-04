<?php
	
	$upToken = file_get_contents('http://aonephy.top/api/Qiniu/getToken.php');
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1, maximum-scale=1.0">
		<link rel="stylesheet" href="/css/bootstrap.min.css">  
		
		<link rel="Shortcut Icon" href="/ppxb.ico" />
		<style>
			#content{width: 800px;margin: 50px auto;}
		</style>
		
		<script src="/jquery/jquery-1.11.3.min.js"></script>
		
		<script src="/js/bootstrap.min.js"></script>
	
	</head>
	<body>
		<div id='content'>
			<div class="btn btn-info">上传</div>
		</div>
		
		<form method="post" action="http://up-z1.qiniup.com" enctype="multipart/form-data">
		  <input name="token" type="hidden" value="<?=$upToken?>">
		  <input name="file" type="file" />
		  <input type="submit" value="上传"/>
		</form>
	</body>
</html>