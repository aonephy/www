<?php
	include("../conf/conn.php");

	$user=$_SESSION['user'];
	if(!empty($user)){
		$upToken = file_get_contents('http://aonephy.top/api/Qiniu/getToken.php');
		
		$ownerId = mysql_fetch_array(mysql_query("select id from user where userid='$user'"))[0];
		
?>
<!DOCTYPE html>
<html>
	<head>
		<title>皮皮侠音乐</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1, maximum-scale=1.0">
		<link rel="stylesheet" href="/css/bootstrap.min.css">  
		<link rel="stylesheet" href="css/bootstrap-slider.min.css">  
		<link rel="Shortcut Icon" href="/ppxb.ico" />
		<style>
			#content{width: 800px;margin: 50px auto;}
			#music-list{text-align: center;border: 1px solid #eee}
			.music-title{text-align: left}
			#nav{margin: auto;text-align: center}
			#form{display: none}
			.glyphicon{top:0px}
		</style>
		
		<script src="/jquery/jquery-1.11.3.min.js"></script>
		<script src="/js/vue.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<script src="js/axios.min.js"></script>
	</head>
	<body>
		<div id="content">
			<div class='btn btn-info' @click="add">
				<a><span class="glyphicon glyphicon-plus" style="color: #fff"></span></a> 新增
			</div>
			<p>
			<table id='music-list' class="table table-striped table-hover">
				<thead>
					<tr class="info">
						<td>序号	</td>
						<td width="300">歌曲名称</td>
						<td width="100">歌手</td>
						<td width="120">上传人</td>
						<td>上传时间</td>
						<!--
						<td>操作</td>
						-->
					</tr>
					
				</thead>
				<tbody>
					<tr v-for='rs,index in list'>
						<td>{{(d.pageIndex-1)*d.pageSize+index+1}}</td>
						<td class='music-title'>{{rs.title}}</td>
						<td>{{rs.author}}</td>
						<td>{{rs.username}}</td>
						<td>{{rs.datetime}}</td>
					
					</tr>
				</tbody>
			</table>
			
			<div id='nav'>
				<ul class="pagination pagination-">
					<li v-on:click="first" v-bind:class="{disabled:CON.pageIndex==1}"><a class="glyphicon glyphicon-step-backward"></a></li>
					<li v-on:click="prev" v-bind:class="{disabled:CON.pageIndex==1}"><a class="glyphicon glyphicon-chevron-left"></a></li>
					<li v-for="pager in pagers" v-on:click="go(pager)" v-bind:class="{active:CON.pageIndex==pager}"><a >{{pager}}</a></li>
					<li v-on:click="next" v-bind:class="{disabled:CON.pageIndex==CON.totalPage}"><a class="glyphicon glyphicon-chevron-right"></a></li> 
					<li v-on:click="last" v-bind:class="{disabled:CON.pageIndex==CON.totalPage}"><a class="glyphicon glyphicon-step-forward"></a></li> 
					
				
				</ul>
			</div>
			
			
			<form id='form' method="post" action="http://up.qiniup.com" enctype="multipart/form-data">
			  <input name="token" type="hidden" value="<?=$upToken?>">
			  <input name="file" id="file" type="file" @change="getFile($event)" />
			  <input type="submit" value="上传"/>
			</form>
			
		</div>
		
		
		<script type="text/javascript">
			var CON = {
					pageIndex : 1,
					pageSize : 10,
					navPZ : 5,
					totalPage:null,
					pagers:[]
				}
			
			
			//config list
		    var vm = new Vue({
		        el: '#content',
		        data: {
		            list:[],
					pagers:[],
					d:null,
					totalPage:null
		        },
		        methods: {
		             prev(){
				        if(CON.pageIndex > 1)
				            this.go(CON.pageIndex - 1)
			        },
			        next(){
						if(CON.pageIndex < CON.totalPage)
							this.go(CON.pageIndex + 1)
			        },
			        first(){
			            if (CON.pageIndex !== 1) {
			                this.go(1)
			            }
			        },
			        last(){
			            if (CON.pageIndex != CON.totalPage) {
			                this.go(CON.totalPage)
			            }
			        },
			        go(page) {
				        
			            CON.pageIndex = page;

			            getData(vm)
			            
			            let PZ = parseInt(CON.navPZ/2);
						var cur,arr=[]; 
						if(CON.pageIndex<=PZ){ 
							cur = PZ + 1; 
						}else if((CON.totalPage-PZ)<=CON.pageIndex){
							cur = CON.totalPage - PZ;
						}else{
							cur = CON.pageIndex;
						}
						
			        },
			        add(){
				        document.getElementById("file").click();
			        },
			        getFile(event) {
			            file = event.target.files[0];
			          
			            let param = new FormData(); 
			            param.append('file',file,file.name)
			            param.append('token','<?=$upToken?>')
			            
						let config = {
							headers:{'Content-Type':'multipart/form-data'}
						};
		            	axios.post('http://up-z1.qiniup.com',param,config)
		            	.then(function(res){
			            //	console.log(res.data)
				            let param = new FormData(); 
				            param.append('fileName',res.data.hash)
				            param.append('ownerId','<?=$ownerId?>')
				            
			            	axios.post('api/recordFile.php',param)
			            	.then(function(res){
				            	console.log(res.data)
				            	vm.go(1);
			            	})
			            	.catch(function(error){
				            		
			            	})
		            	})
		            	.catch(function(error){
			            		
		            	})
					}
		        },     
				mounted: function(){
					getData(this);
				}		
		    })
		    
		    
		    
		   	function getData(vm){
			   	
			   	axios.get('api/getMusicList.php?page='+CON.pageIndex+'&pagesize='+CON.pageSize)
				  .then(function (res) {
				    // 处理响应
			    	vm.list = res.data.data,vm.d = res.data ;

		            var len = CON.pageSize - res.data.data.length;
				//	console.log(vm.d.totalPage)
					// 清单不满pagesize时补空值
					for(var i=0;i<len;i++){
				    	vm.list.push('')						
					}

			    	vm.totalPage = res.data.totalPage;
			    	CON.totalPage = res.data.totalPage;
				    	
				    	
					var arr = [];

					CON.navPZ = CON.navPZ<CON.totalPage ? CON.navPZ:CON.totalPage

					for(var i=0;i<CON.navPZ;i++){
						arr.push(i + 1)
					}
					vm.pagers = arr;
				    	
				  })
				  .catch(function (error) {
				    // 网络异常引发的错误
				});
		   	}

					
		</script>
	</body>
</html>
<?php
	}else{
		$address=$_SERVER['REQUEST_URI'];
		$address=urlencode($address);
		$url = "/bbs/login.php?dir=".$address; 
		Header("Location:$url");
	}
?>