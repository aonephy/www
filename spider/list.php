<!Doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="/css/bootstrap.min.css">  
		<style>
			body{word-break:break-all}
			input{    width: 300px;    height: 30px;    padding: 3px;}
			.table{width:1100px;margin:20px auto;text-align:center;}
		</style>
		<script src="/js/jquery-1.11.3.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
	</head>
	<body>
		
		<table class='table table-bordered table-hover table-striped'>
			<thead>
				<tr class="info">
					<td>序号</td>
					<td>商户名称</td>
					<td>商户编号</td>
					<td>支付类型</td>
					<td>支付渠道</td>
					<td>建立时间</td>
					<td>状态</td>
				</tr>
			</thead>
			<tbody>
			</tbody>
			
		</table>
	
		<script>
			$(document).ready(function(){
				
				$.ajax({
					url:'outjson/1524191721_admin-api.sayahao.com.txt',
					dataType:'json',
					success:function(rs){
						console.log(rs)
						var data = rs.data;
						var index=1;
						for(var i=0;i<data.length;i++){
							if(data[i].is_enabled=='<?=$_GET['s']?>'||'<?=$_GET['s']?>'=='all'){
							var html = "<tr>";
								html += "<td>"+(index++)+"</td>";
								html += "<td>"+data[i].name+"</td>";
								html += "<td>"+data[i].app_id+"</td>";
								html += "<td>"+data[i].type+"</td>";
								html += "<td>"+data[i].channel+"</td>";
								html += "<td>"+data[i].created+"</td>";
								html += "<td>"+data[i].is_enabled+"</td>";
								html += "</tr>";
							
								$("tbody").append(html);
								
							}
						}
					}
				})
			})
			
			
		</script>
	</body>
	
</html>	