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
			.form-group{display:-webkit-box}
			.alert{position:absolute;top:10px;right:50px;width:250px;display:none}
			#content .active{display:block}
			.pagination{display:-webkit-inline-box;}
			
			.sr-only{width:100%;height:20px;left:0px;clip:unset;color:#000}
		</style>
		
		<script src="/jquery/jquery-1.11.3.min.js"></script>
		<script src="/js/vue.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<script src="js/axios.min.js"></script>
		<script src="/js/fileUploadProgress.js"></script>
	</head>
	<body>
	
		<div id="content">
			<div class="alert alert-warning" v-bind:class='{active:!activeIndex}'>歌曲上传中！</div>
			<div class='btn btn-info' v-bind:class='{disabled:!activeIndex}' @click='showModal'>
				<a><span class="glyphicon glyphicon-plus" style="color: #fff"></span></a> 上传音乐
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
					<tr v-for='rs,index in list' height='37'>
						<td><span v-if='rs'>{{(d.pageIndex-1)*d.pageSize+index+1}}</span></td>
						<td class='music-title'>{{rs.title}}</td>
						<td>{{rs.author}}</td>
						<td>{{rs.username}}</td>
						<td>{{rs.datetime}}</td>
					
					</tr>
				</tbody>
			</table>
			
			<div id='nav'>
				<ul class="pagination">
					<li v-on:click="first" v-bind:class="{disabled:CON.pageIndex==1}"><a class="glyphicon glyphicon-step-backward"></a></li>
					<li v-on:click="prev" v-bind:class="{disabled:CON.pageIndex==1}"><a class="glyphicon glyphicon-chevron-left"></a></li>
					<li v-for="pager in pagers" v-on:click="go(pager)" v-bind:class="{active:CON.pageIndex==pager}"><a>{{pager}}</a></li>
					<li v-on:click="next" v-bind:class="{disabled:CON.pageIndex==CON.totalPage}"><a class="glyphicon glyphicon-chevron-right"></a></li> 
					<li v-on:click="last" v-bind:class="{disabled:CON.pageIndex==CON.totalPage}"><a class="glyphicon glyphicon-step-forward"></a></li>
				</ul>
			</div>
			<form id='form' >
			  <input name="token" type="hidden" value="<?=$upToken?>">
			  <input name="file" id="file" type="file" @change="getFile($event)" />
			  <input type="submit" value="上传"/>
			</form>
			
			
			<!-- 模态框（Modal） -->
			<div class="modal fade" id="myModal" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" @click='closeModal'>&times;</button>
							<h4 class="modal-title" id="myModalLabel">上传音乐</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="musicName" class="col-sm-2 control-label">歌曲名称</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" id="musicName" placeholder="请输入歌曲名称" v-model='musicName' required>
								</div>
							</div>
							<div class="form-group">
								<label for="musicAuthor" class="col-sm-2 control-label">歌手</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" id="musicAuthor" placeholder="请输入歌手" v-model='musicAuthor' required>
								</div>
							</div>
							<div class="form-group">
								<label for="musicFile" class="col-sm-2 control-label">歌曲</label>
								<div class="col-sm-10">
								  <input type="file" class="form-control" id="musicFile" @change="getFile" accept='audio/*'>
								</div>
							</div>
							
							<div class="form-group" style='margin-bottom:0px'>
								<div class="col-sm-2">
								</div>
								<div class=" col-sm-10">
									<div class="progress progress-striped" style='margin-bottom:0px'>
										<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
											<span class="sr-only"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" @click='closeModal'>关闭</button>
							<button type="button" id='uploadBtn' class="btn btn-info" v-bind:class='{disabled:!activeIndex}' @click='uploadFile'>上传</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal -->
			</div>
			
			
			
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
					musicName:'',
					musicAuthor:'',
					musicFile:'',
					d:null,
					activeIndex:true,
					totalPage:null
		        },
		        methods: {
		            prev:function(){
				        if(CON.pageIndex > 1)
				            this.go(CON.pageIndex - 1);
			        },
			        next:function(){
						if(CON.pageIndex < CON.totalPage)
							this.go(CON.pageIndex + 1);
			        },
			        first:function(){
			            if (CON.pageIndex !== 1) {
			                this.go(1);
			            }
			        },
			        last:function(){
			            if (CON.pageIndex != CON.totalPage) {
			                this.go(CON.totalPage);
			            }
			        },
			        go:function(page) {
						this.clearModal();
			            CON.pageIndex = page;
			            this.getData();
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
			        add:function(){
				        document.getElementById("file").click();
			        },
					showModal:function(){
						if(this.activeIndex){
							$('#myModal').modal('show');
							document.getElementById('musicName').focus();
							$('.progress-bar').css('width','0%');
						}
					},
					closeModal:function(){
						$('#myModal').modal('hide');
						this.clearModal();
					},
					clearModal:function(){
						this.musicName = '';
						this.musicAuthor = '';
						this.musicFile = '';
						document.getElementById('musicFile').value='';
					},
					getInfo:function(){
						console.log(this.musicName);
						console.log(this.musicAuthor);
						console.log(this.musicFile);
					},
			        getFile:function(event) {
					//	console.log(event.target.files);
						this.musicFile = event.target.files[0];
						$('.progress-bar').css('width','0%');
						$('.sr-only').html('0%');
					},
					uploadFile:function(){
						if(!this.activeIndex) {
							return
						}
						if(this.checkValue()){							
							this.activeIndex = false;
							let file = this.musicFile;
							
							let param = new FormData(); 
							param.append('file',file,file.name);
							param.append('token','<?=$upToken?>');
							
							let config = {
								headers:{'Content-Type':'multipart/form-data'},
								onUploadProgress:function(e){
								//	console.log(e);
									var progress = parseInt(e.loaded / e.total * 100, 10);
									$('.progress-bar').css('width',progress + '%');
									$('.sr-only').html(progress + '%');
								}
							};
							axios.post('http://up-z2.qiniup.com',param,config)
							.then(function(res){
								console.log(res.data);
								//清楚进度条
								
								let param = new FormData(); 
								param.append('fileName',res.data.hash);
								param.append('musicName',vm.musicName);
								param.append('musicAuthor',vm.musicAuthor);
								param.append('ownerId','<?=$ownerId?>');
								
								//上传成功后记录到数据库中
								axios.post('api/recordFile.php',param)
								.then(function(res){
								//	console.log(res.data);
									vm.go(1);
									vm.activeIndex = true;
								})
								.catch(function(error){
										
								})
							})
							.catch(function(error){
									
							})
						}
					},
					checkValue:function(){
						if(this.musicName==''){
							alert("歌名不能为空！");
						}else if(this.musicAuthor==''){
							alert("歌手不能为空！");
						}else if(this.musicFile==''){
							alert("歌曲文件不能为空！");
						}else{
							return true;
						}
					},
					getData:function(){
						console.log('load music list!')
						axios.get('api/getMusicList.php?page='+CON.pageIndex+'&pagesize='+CON.pageSize)
						  .then(function (res) {
							// 处理响应
							vm.list = res.data.data,vm.d = res.data ;

							var len = CON.pageSize - res.data.data.length;
							// 清单不满pagesize时补空值
							for(var i=0;i<len;i++){
								vm.list.push('')						
							}
							vm.totalPage = res.data.totalPage;
							CON.totalPage = res.data.totalPage;
							var arr = [];
							CON.navPZ = CON.navPZ<CON.totalPage ? CON.navPZ:CON.totalPage;
							for(var i=0;i<CON.navPZ;i++){
								arr.push(i + 1)
							}
							vm.pagers = arr;
								
						  })
						  .catch(function (error) {
							// 网络异常引发的错误
						});
					},
				},				
				mounted: function(){
					this.getData();
				}		
		    })
		       

					
		</script>
	</body>
</html>
<?php
	}else{
		$address = $_SERVER['REQUEST_URI'];
		$address = urlencode($address);
		$url = "/bbs/login.php?dir=".$address; 
		Header("Location:$url");
	}
?>