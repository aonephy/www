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
			#form{//display: none}
			.glyphicon{top:0px}
			.alert{position: absolute;top:20px;width: 300px;right: 100px}
		</style>
		
		<script src="/jquery/jquery-1.11.3.min.js"></script>
		<script src="/js/vue.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<script src="js/axios.min.js"></script>
	</head>
	<body>
		<div id="content">
			<div id='add-btn' class="btn btn-info" v-bind:class="{disabled:disabled}" @click='openModal'>
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
						<td class='music-title' @click="test(rs.id)">{{rs.title}}</td>
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
			
			
		
			
			<!-- 模态框（Modal） -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-dialog">
			        <div class="modal-content">
			            <div class="modal-header info">
			                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			                <h4 class="modal-title" id="myModalLabel">上传音乐</h4>
			            </div>
			            <div class="modal-body">
				            <form id='form' method="post" action="http://up-z1.qiniup.com" enctype="multipart/form-data" role="form">
								<input name="token" type="hidden" value="<?=$upToken?>">
								<div class="form-group">
									<label for="music-name">歌曲名称</label>
									<input type="text" v-model='musicName' class="form-control" id="music-name" name="music-name" placeholder="请输入歌曲名" required>
								</div>
								<div class="form-group">
									<label for="music-author">歌手</label>
									<input type="text" v-model='musicAuthor' class="form-control" id="music-author" name="music-author" placeholder="请输入歌手" required>
								</div>
								<div class="form-group">
									<label for="file">歌曲</label>
									<input type="file" class='form-control' id="file" name="file" @change="getFile($event)" accept='audio/*' required>
								</div>	
							</form>
				            
			            </div>
			            <div class="modal-footer">
			                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			                <button type="button" class="btn btn-info" @click="upFile()">提交</button>
			            </div>
			        </div><!-- /.modal-content -->
			    </div><!-- /.modal -->
			</div>
			
			<div class="alert alert-success">文件上传中...</div>
			
			
		</div>
		
		
		
		<script type="text/javascript">
			var CON = {
					pageIndex : 1,
					pageSize : 10,
					navPZ : 5,
					totalPage:null,
					pagers:[]
				}
			
			$(".alert").hide()
						
			//config list
		    var vm = new Vue({
		        el: '#content',
		        data: {
		            list:[],
					pagers:[],
					d:null,
					totalPage:null,
					file:null,
					musicName:null,
					musicAuthor:null,
					disabled:0,
					tmp:1
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
					test(obj){
						console.log(obj)
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
			        openModal(){
				      	if(!this.disabled){
					      	$("#form").get(0).reset();
							this.musicName = null;
							this.musicAuthor = null;
							$("#myModal").modal('show');
					    }
					    
					    console.log(this.musicName)
					                
			        },
			        getFile(event) {
			            this.file = event.target.files[0];
			            var fileType = this.file.type;
			            
			            if(fileType.indexOf('audio')<0){
											            
							$("#file").val('');
							alert('文件格式不正确，请重选文件！');
			            }
					},
					upFile(){
						var that = this;
						file = this.file
			            
						let config = {
							headers:{'Content-Type':'multipart/form-data'}
						};
						
						
						var flag;
						
						if(this.musicName==null||this.musicAuthor==null||file==null){
							flag = 0;
						}else{
							flag = 1;
						}
						
						
							if(flag==0){
								alert('数据无效，请检查数据不能空值！')
							}else{
								//数据校验通过
								console.log()
								$('#myModal').modal('hide')
								$(".alert").fadeIn("slow");
								this.disabled = true;
								
								let param = new FormData(); 
					            param.append('file',file,file.name);
					            param.append('token','<?=$upToken?>');
					            
								//上传
				            	axios.post('http://up-z1.qiniup.com',param,config)
				            	.then(function(res){
					            //	console.log(res.data)
						            let param = new FormData(); 
						            param.append('fileName',res.data.hash);
						            param.append('ownerId','<?=$ownerId?>');
									param.append('musicName',that.musicName);
									param.append('musicAuthor',that.musicAuthor);
						            //上传成功，记录到数据库
					            	axios.post('api/recordFile.php',param)
					            	.then(function(res){
						            //	console.log(res.data)
						            	
						            	//hide note info
										$(".alert").fadeOut("slow");
										that.disabled = false;
										//update the list
						            	vm.go(1);
					            	})
					            	.catch(function(error){
						            		
					            	})
				            	})
				            	.catch(function(error){
					            		
				            	})
				            }
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