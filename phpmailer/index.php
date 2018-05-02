<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes, minimum-scale=0.1, maximum-scale=3.0">
		
		<link rel="stylesheet" href="../css/bootstrap.min.css">  
		<link rel="stylesheet" type="text/css" href="../css/wangEditor.min.css">
		
		<style>
			#a-body{background: #fff;text-align:center;margin: auto;width: 60%}
			#content{height: 300px}
			#submit{margin: auto;width: 80%}
		</style>
		<script src="../js/jquery-1.11.3.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
	
		<title>Mali</title>
		<script>
		
			$(document).ready(function(){
				
			})
		
			function send(){


				$.ajax({
					url:'finish.php?mo=s&id='+id,
					dataTpye:'json',
					success:function(rs){
					//	console.log(rs.code);
					
					}
				})
			}
		</script>
	</head>
	<body>
		<br>

		<div id='a-body'>
			<form class="form-horizontal" role="form" method="post" action="send.php">
				<div class="form-group">
				    <label for="toMail" class="col-sm-1 control-label">To</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="toMail" name="toMail" placeholder="请输入mail">
				    </div>
				</div>
				<div class="form-group">
				    <label for="title" class="col-sm-1 control-label">主题</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="title" name="title" placeholder="请输入主题">
				    </div>
				</div>
				<div class="form-group">
				    <label for="content" class="col-sm-1 control-label">内容</label>
				    <div class="col-sm-10">
				      <textarea class="form-control" id="content" name="content" placeholder="请输入内容"></textarea>
				    </div>
				</div>
				<div class="form-group">
					<input type="submit" id="submit" name="submit" class="btn btn-info btn-block">
				</div>
			</form>
			
		</div>
	<script type="text/javascript" src="../js/wangEditor.min.js"></script>
	<script type="text/javascript"> 
     
	    var editor = new wangEditor('content');
	    // 上传图片（举例）
	    editor.config.uploadImgUrl = '../wangeditor/index.php';

	    // 配置自定义参数（举例）

	
	    // 设置 headers（举例）
	    editor.config.uploadHeaders = {
	        'Accept' : 'text/x-json'
	    };
	
	    // 隐藏掉插入网络图片功能。该配置，只有在你正确配置了图片上传功能之后才可用。
//	    editor.config.hideLinkImg = true;
	    editor.create();
    </script>

	</body>
</html>
	