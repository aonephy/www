<?php
	session_start();
	$user=$_SESSION['user'];
	if(!empty($user)){
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
		<script src="/jquery/jquery-1.11.3.min.js"></script>
		<script src="js/bootstrap-slider.min.js"></script>

		<script src="/js/vue.min.js"></script>
		<script src="js/axios.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<style>
			body{background-image:url(images/51206f4be3528.jpg);word-break: break-word}
			#play{width:100%;height:80px;position:fixed;bottom:0px;}
			#play-control{width:300px;display:inline-block;position:absolute;top:0px}
			#play-info{width:1200px;display:inline-block;position: absolute;  left: 300px;  top: 0px;}
			#play-control a{background-image:url(images/icon.png);background-repeat:no-repeat;border:0px solid red;position:relative;width:30px;height:30px;display:block;top:28px}
			#play-control div{display:inline-block;}
			#prevBtn{left:60px;background-position:0px -90px}
			#prevBtn:hover{background-position:-30px -90px}
			#playBtn{left:90px;background-position:0px -30px}
			#playBtn:hover{background-position:-30px -30px}
			#play-control .pauseBtn{background-position:0px 0px}
			#play-control .pauseBtn:hover{background-position:-30px 0px}
			#nextBtn{left:120px;background-position:-2px -60px}

			#nextBtn:hover{background-position:-32px -60px}
			#ex1Slider .slider-track {background: #BABABA;}
			#volume .slider-track {background: #BABABA;}
			.slider-handle{background:#fff;width:15px;height:15px;margin-top;-4px;}
			#jindu{position: absolute;top:35px;}
			#ex1Slider{width: 700px;}
			#mp3-name{color:#fff;padding-top: 10px;}
			#timeLineStart,#timeLineEnd{color: #fff;display:inline-block;position:relative;top:-1px;}
			#timeLineStart{margin-right:20px}
			#timeLineEnd{margin-left:20px}
			#volume{width:100px;margin-left:30px}
			#volume-icon{background-image:url(images/icon.png);background-repeat:no-repeat;background-position:0px -296px;display:inline-block;width:20px;height:18px;margin-left:30px;position:relative;top:1px }
			#playList{margin: auto;width: 700px;color:#fff;overflow:auto}
			#playListTable{margin-top: 20px;font-size: 1.0em}
			.music-item:hover{//color: #888;cursor: pointer;}
			.music-item:hover .music-title{display:inline-block;}
			.music-item:hover .music-index{display:none}
			.music-item:hover .glyphicon-play-circle{display:inline-block}
			#playListTable thead{font-weight:800}
			.music-index{margin: 0px 10px;}
			.glyphicon-chevron-down:hover{color:#ddd}
			.glyphicon-play-circle{margin: 0px 6px 0px 8px;display:none}
			#play-background{background:#666666;opacity: 0.6;height:100%}
			.open>.dropdown-menu{right:0px;border:1px solid #eee;min-width:80px;left:unset}
			#libraryList .form-group{margin: 5px;display: inline-block}
			.myLibraryList-box{margin: auto;/border: 1px solid #ccc;float:left;vertical-align: top;}
			#myLibraryListMenu{width: 25%;margin-right:10px;background:#fff;color:#666;position:relative;height:100%;}
			#myLibraryListMusic{width: 70%;overflow-y:auto;height:100%}
			.libraryListMenu-item{padding:10px;border-bottom:1px solid #eee}
			.libraryListMenu-item:hover{background:#eee}
			
			#musicList{padding:10px}
			.music-author{color:#eee;padding-left:32px;}
			.libraryListMusic-item dl{//border-bottom:1px solid #eee;margin-bottom:10px}
			.libraryListMusic-item hr{width:100%;margin:0px}
			#myLibraryList {margin-top:5px;}
			.myLibraryList-box .active{background:#eee;color:#222;border-left:5px solid #f52908;}
			
			#p-body .title li{padding:10px;display:table-cell;text-align: center;width: 50%;float:left}
			#p-body .title{height:40px}
			#p-body .title a{text-decoration:none;color:#fff;font-weight: 800}
			#p-body .title {border-bottom:2px solid #fff;}
			#p-body .title .active{background: #fff;border-top-left-radius: 2px;border-top-right-radius: 2px;}
			#p-body .title .active a{color:#666}
			#p-body .title{margin: auto;width: 700px;padding: 0px}
			
			
			@media handle,only screen and (max-width:450px){
				#play{height:110px;}
				#playList{width: 100%;}#playListTable{margin:0px}
				#p-body .title{width: 100%;//padding-top:10px}
				#play-control a{top:10px;position: unset;margin: auto;}
				#play-control div{width:33.33%;position:relative;top:10px}
				#play-info{top:40px;left:unset}
				#volume-icon{display:none}
				#play-control, #play-info{float:unset;width:100%}
				#mp3-name{text-align:center}
				#jindu{position:relative;top:5px;width:100%;text-align:center;margin:auto;width:95%}
				#ex1Slider{width:65%;margin:auto;}
				#timeLineStart,#timeLineEnd{position:absolute}
				#timeLineStart{left:0px}
				#timeLineEnd{right:0px}
			}
			
			
			table tbody {display:block;	overflow-y:auto;padding-bottom: 60px;}
			table thead, tbody tr {	display:table;	width:100%;	table-layout:fixed;}
			table thead {//	width: calc( 100% - 1em )}
			table thead th{ background:#ccc;}
			tbody tr:hover{color:#888}
			.table>tbody>tr>td{padding:8px 0px}
		</style>
		
	</head>
	<body>
		
		<div id='p-body' >
			<ul class='title'>
				<li class='active' @click="getMusic"><a href="#musicList" data-toggle="tab">所有音乐</a></li>
				<li @click="resetLibrarySelected"><a href="#myLibraryList" data-toggle="tab">我的歌单</a></li>
			</ul>
				
			<div id="playList" class="tab-content">
				
				
				<div class="tab-pane" id="myLibraryList" >
					<div id='myLibraryListMenu' class="myLibraryList-box">
						<div style="background:#fff;overflow-y:auto;height:100%;padding-bottom:35px">
							<div v-for="rs,index in libraryList" class='libraryListMenu-item' v-bind:class="{active:index==ins}" @click="getLibraryListMusic(index);active(index)" >
								{{rs.libName}}
							</div>
						</div>
						<div class="btn btn-default btn-block" style="position:absolute;bottom:0px;border-radius:0px" @click="showAddLibDialog">
							<a>
								<span class="glyphicon glyphicon-plus" ></span>新歌单
							</a>
						</div>
					</div>

					<div id='myLibraryListMusic' class="myLibraryList-box">
							<div v-for="rs,index in libraryMusicList" class='libraryListMusic-item music-item' @click="play(index)">
								<dl>
									<span class="music-index">{{index+1}}</span>
									<span class='glyphicon glyphicon-play-circle'></span>
									<span class='music-title'>{{rs.title}}</span>
									<p class='music-author'>{{rs.author}}</p>
									<hr>
								</dl>
							</div>					
						
								
					</div>
				</div>
				
				<div class="tab-pane active" id="musicList">
					<table id='playListTable' class="table table-hover" >
						<thead>
							<tr>
								<td>歌曲</td>
								<td width='60'>演唱者</td>
								<td width='30'></td>
							</tr>
						</thead>
						<tbody id='tbody'>
							<tr v-for='rs,index in viewList' >
								<td>
									<div :id="rs.id" class=' music-item' @click='play(index)'>
										<span class='music-index'>{{index+1}}</span>
										<span class='glyphicon glyphicon-play-circle'></span>
										<span class='music-title'>{{rs.title}}</span>
									</div>
								</td>
								<td width='60'>
									<span>{{rs.author}}</span>
								</td>
								<td width='30'>
									<div class='dropdown'>
										<span class='glyphicon glyphicon-chevron-down'  data-toggle='dropdown'></span>
										<ul class='dropdown-menu fright' role='menu' aria-labelledby='myTabDrop1'>
											<li><a class='addToList' tabindex='-1' data-toggle='tab' @click='ShowAddToListDialog(index)'>加入到歌单</a></li>
											<li><a  tabindex='-1' data-toggle='tab' @click='showAddLibDialog'>添加新歌单</a></li>
										</ul>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				
			</div>

			<!-- 模态框（Modal） -->
			<div class="modal fade" id="addLibrary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-dialog">
			        <div class="modal-content">
			            <div class="modal-header info">
			                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			                <h4 class="modal-title" id="myModalLabel">新增歌单</h4>
			            </div>
			            <div class="modal-body">

								<div class="form-group">
									<label for="libraryName">歌单名称</label>
									<input type="text" v-model='libraryName' class="form-control" id="libraryName" name="libraryName" placeholder="请输入歌单名" required autofocus="autofocus">
								</div>
				            
			            </div>
			            <div class="modal-footer">
			                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			                <button type="button" class="btn btn-info" @click="addLibrary()">提交</button>
			            </div>
			        </div><!-- /.modal-content -->
			    </div><!-- /.modal -->
			</div>
						
			<!-- 模态框（Modal） -->
			<div class="modal fade" id="libraryList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-dialog">
			        <div class="modal-content">
			            <div class="modal-header info">
			                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			                <h4 class="modal-title" id="myModalLabel">加入到歌单</h4>
			            </div>
			            <div class="modal-body">
				            	<div class="form-group" v-for="rs,index in libraryList">
									<input type="radio" :id="rs.libId" :value="index" v-model="libraryIndex">
									<label :for="rs.libId">{{rs.libName}}</label> 
								</div>
			            </div>
			            <div class="modal-footer">
			                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			                <button type="button" class="btn btn-info" @click="addToList()">提交</button>
			            </div>
			        </div><!-- /.modal-content -->
			    </div><!-- /.modal -->
			</div>
	
		




		
		
		</div>
		
			<div id="play">
				<audio src='' ></audio>
				<div id="play-background"></div>
				<div id='play-control'>
					<div>
						<a id='prevBtn'></a>
					</div><div>
						<a id='playBtn' class='pauseBtn'></a>
					</div><div>
						<a id='nextBtn'></a>
					</div>
				</div>
				
				<div id='play-info'>
					<div id='mp3-name'></div>
					<div id='jindu' style="">
						<div id="timeLineStart"></div>
						<input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="1000" data-slider-step="0.2" data-slider-value="0"/>
						<div id="timeLineEnd"></div>
						<div id="volume-icon">
							<input id="volume" data-slider-id='volume' type="text" data-slider-min="0" data-slider-max="10" data-slider-step="0.1" data-slider-value="5"  />
						</div>
						
					</div>
				</div>
			</div>
			

		<script>
			var audio = $("audio")[0]
			var mySlider = $("#ex1").slider();
			var mySlider2 = $("#volume").slider();
			var index;
			
			//config list
		    var vm = new Vue({
		        el: '#p-body',
		        data: {
					ins:null,//歌单激活active
					playList:[],
					viewList:[],
					res:null,
					libraryList:[],//加载歌单及其中的音乐
					libraryMusicList:[],//展示歌单中音乐
					libraryName:null,
					libraryIndex:null,//歌单数组index
					musicIndex:null,
					isActive:true
		        },
		        methods: {
			        play(resId){
						this.playList = this.viewList;
						console.log(resId);
						playMusic(resId);
			        },
			        ShowAddToListDialog(resId){
					//	console.log(this.libraryList);
				        this.musicIndex = resId;
						$("#libraryList").modal('show');
			        },
			        addToList(){
					//	console.log(this.res.data[this.musicIndex].id)
						
						let data = {libId:this.libraryList[this.libraryIndex].libId,musicId:this.res.data[this.musicIndex].id};
						data = FormatData(data)
						
						axios({
							url:'api/addLibraryMusic.php',
							method: 'post',
							data:data,
							responseType: 'json',
							transformResponse: [function(res){
							//	console.log(res)
								if(res.code==10000){
									$("#libraryList").modal('hide');
									vm.libraryList[vm.libraryIndex].musicList.push(vm.res.data[vm.musicIndex ])
								}else if(res.code==10002){
									alert(res.msg)
								}
							}]
						});
						
			        },
					showAddLibDialog(){
						//弹出添加歌单模态窗
				        $("#addLibrary").modal('show');
						$('#addLibrary').on('shown.bs.modal',function(e){
							$("#libraryName").focus();
				        })
			        },
			        addLibrary(){						
				        if(vm.libraryName == null){
					        alert("请输入有效的歌单名字！");
					        $("#libraryName").focus();
				        }else{
					        $("#addLibrary").modal('hide');

							//创建歌单数据
				            let param = FormatData(
								{libraryName:vm.libraryName}
							); 
							
							axios.post('api/addLibrary.php',param)
							  .then(function (res) {

							  	//赋值
							  	if(res.data.code==10000){
							    	// 处理响应
								//	vm.list = res.data.data,vm.res = res.data ;
									vm.libraryList.push(res.data.data)
									vm.libraryName = null;
									console.log(vm.libraryList);
						    	}else{
							    	alert(res.data.msg)
						    	}	
							  })
							  .catch(function (error) {
							    // 网络异常引发的错误
							});
				        }
			        },
					getLibraryListMusic(id){
						//基于歌单数组index获取歌单的音乐
						this.libraryMusicList = this.libraryList[id].musicList
						this.viewList = this.libraryList[id].musicList						
					},
					active(num){
						this.ins = num
					},
					getMusic(){
						axios.get('api/getMusic.php')
						  .then(function (res) {
						  	//赋值
						  	if(res.data.code==10000){
						    	// 处理响应
								vm.viewList = res.data.data,
								vm.res = res.data;
					    	}else{
						    	console.log(res.data)
					    	}	
						  })
						  .catch(function (error) {
						    // 网络异常引发的错误
						});

					},
					resetLibrarySelected(){
						this.ins = null
						this.libraryMusicList = null
					}
			        
		        },     
				mounted: function(){
						this.getMusic();
						axios.get('api/getLibraryList.php')
						  .then(function (res) {
						  	//赋值
						  	if(res.data.code==10000){
						    	// 处理响应
								vm.libraryList = res.data.data;
								
					    	}else{
						    	console.log(res.data)
					    	}	
						  })
						  .catch(function (error) {
						    // 网络异常引发的错误
						});
						
				}
			})
						
			function FormatData(data){
				let paramters = new FormData(); 
				for(var key in data){
					paramters.append(key,data[key])
				}
				return paramters;
			}
			
			
			$(document).ready(function(){
				$("#tbody").css('height',(document.documentElement.clientHeight-210))
				$("#myLibraryList").css('height',(document.documentElement.clientHeight-190))
				
				// With JQuery
				$('#ex1').slider({
					formatter: function(value) {
						return FormatTime(value);					
					}
				});
				//上一曲
				$("#prevBtn").click(function(){
					if(index==0)
						index = vm.playList.length; 
					playMusic(--index);
				})
				//下一曲
				$("#nextBtn").click(function(){
					if(index==(vm.playList.length-1))
						index = -1;
					playMusic(++index);
				})	
				//音乐加载后
				audio.addEventListener('loadedmetadata', function () { 
					mySlider.slider('getAttribute').max = audio.duration;
					$("#timeLineEnd").html(FormatTime(audio.duration));
				})
				//自动下一曲
				audio.addEventListener('ended', function () { 
					$("#nextBtn").click();
				})
				//监听音量拖拽
				mySlider2.bind('slide',function(res){
				//	console.log(res.value)
					audio.volume = res.value/10;
				
				})
				//监听播放停止拖拽
				mySlider.bind('slideStop',function(res){
					//	console.log(res.value)
					audio.currentTime = res.value
					audio.addEventListener("timeupdate",listen)
				})
				//监听拖拽
				mySlider.bind('slide',function(res){
				//	console.log(res.value)
					audio.removeEventListener('timeupdate',listen)
				})
				
				// 监听播放时间
				audio.addEventListener("timeupdate",function(){
					$("#timeLineStart").html(FormatTime(audio.currentTime));
				})
				
			})
			
	
			//设置播放时间
			function listen(){
				if(audio.duration){
					var n = parseInt(audio.currentTime.toFixed(0));
					mySlider.slider('setValue',n)
				}
			}
			
			function FormatTime(time){
					var time = time.toFixed(0);
					var seconds=time%60;
					var minutes=parseInt(time/60%60);
					seconds = seconds > 9 ? seconds:"0"+seconds;
					minutes = minutes > 9 ? minutes:"0"+minutes;
					return minutes+":"+seconds;
			}
		
			function playMusic(id){
			//	console.log(id)
				index = id;

				data = vm.playList[id];
				audio.src = data.audioUrl;
				audio.play();
				$("#mp3-name").html(data.title+" —— "+data.author);
				audio.addEventListener("timeupdate",listen)
				$("#playBtn").removeClass('pauseBtn')

			}		
			
			
			var playFlag = 1;
			$("#playBtn").click(function(){
				if(playFlag == 1){
					audio.pause()
					$("#playBtn").addClass('pauseBtn')
					playFlag = 0;
				}else{
					audio.play()
					$("#playBtn").removeClass('pauseBtn')
					playFlag = 1;
				}
			})
			
			
		$(document).keydown(function(event){
			//键盘控制
			var keyCode = event.keyCode; 
			if(keyCode==179){
				$("#playBtn").click()
			}else if(keyCode==177){
				$("#prevBtn").click()
			}else if(keyCode==176){
				$("#nextBtn").click()
			}
		
		});
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