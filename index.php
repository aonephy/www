<?php
	session_start();
	$user=$_SESSION['user'];
	@$openid = $_GET['openid'];
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
			body{background-image:url(images/51206f4be3528.jpg);word-break: break-word;min-width:800px;}
			#play{width:100%;height:80px;position:fixed;bottom:0px;}
			#play-control{width:300px;display:inline-block;position:absolute;top:0px;max-width:300px}
			#play-info{//width:70%;display:inline-block;position: absolute; top: 0px;}
			#play-control a{background-image:url(images/icon.png);background-repeat:no-repeat;border:0px solid red;position:relative;width:30px;height:30px;display:block;top:28px;margin:auto;}
			#play-control div{display:inline-block;width:33.33%}
			#prevBtn{//left:60px;background-position:0px -90px}
			#prevBtn:hover{background-position:-30px -90px}
			#playBtn{//left:90px;background-position:0px -30px}
			#playBtn:hover{background-position:-30px -30px}
			#nextBtn{//left:120px;background-position:-2px -60px}
			#play-control .pauseBtn{background-position:0px 0px}
			#play-control .pauseBtn:hover{background-position:-30px 0px}
			
			#nextBtn:hover{background-position:-32px -60px}
			#ex1Slider .slider-track {background: #BABABA;}
			#volume .slider-track {background: #BABABA;}
			.slider-handle{background:#fff;width:15px;height:15px;margin-top;-4px;}
			#jindu{position: absolute;top:35px;width:100%}
			#ex1Slider{width: 70%;}
			#mp3-name{color:#fff;padding-top: 10px;}
			#timeLineStart,#timeLineEnd{color: #fff;display:inline-block;position:relative;top:-1px;width:36px}
			#timeLineStart{margin-right:20px}
			#timeLineEnd{margin-left:20px}
			#volume{width:200px;margin-left:20px;display:inline-block}
			#volume-icon{background-image:url(images/icon.png);background-repeat:no-repeat;background-position:0px -295px;display:inline-block;width:20px;height:18px;margin:0px 10px;position:relative;top:3px }
			#volume-control{width:80px;max-width:100px}
			
			#playList{margin: auto;width: 700px;color:#fff;overflow:auto}
			#playListTable{margin-top: 20px;font-size: 1.0em}
			.music-item:hover{//color: #888;cursor: pointer;}
			.music-item:hover .music-title{display:inline-block;}
			.music-item:hover .music-index{display:none}
			.music-item:hover .glyphicon-play-circle{display:inline-block}
			#myLibraryListMusic:hover .active .glyphicon-play-circle{display:none}
			#playListTable :hover .active .glyphicon-play-circle{display:none}
			#playListTable thead{font-weight:800}
			.music-index{margin: 0px 10px;}
			.glyphicon-chevron-down:hover{color:#ddd}
			.glyphicon-play-circle{margin: 0px 6px 0px 8px;display:none}
			#play-background{background:#666666;opacity: 0.6;height:100%}
			.open>.dropdown-menu{right:0px;border:1px solid #eee;min-width:80px;left:unset}
			#libraryList .form-group{margin: 5px;display: inline-block}
			.myLibraryList-box{margin: auto;/border: 1px solid #ccc;float:left;vertical-align: top;}
			#myLibraryListMenu{width: 25%;margin-right:10px;background:#fff;color:#666;position:relative;height:100%;}
			#myLibraryListMusic{width: 70%;overflow-y:auto;height:100%;margin-top:10px}
			.libraryListMenu-item{padding:10px;border-bottom:1px solid #eee}
			.libraryListMenu-item:hover{background:#eee}
			
			
			#musicList{padding:10px}
			.music-author{color:#eee;padding-left:32px;}
			.libraryListMusic-item dl{//border-bottom:1px solid #eee;margin-bottom:10px}
			.libraryListMusic-item hr{width:100%;margin:0px}
			#myLibraryListMenu .active{background:#eee;color:#222;border-left:5px solid #f52908;}
			
			#playListTable .active .glyphicon-play-wave,#myLibraryListMusic .active .glyphicon-play-wave{background-image:url(images/wave.gif);width:10px;height:10px;margin:0px 6px 0px 8px;}
			#playListTable .active .glyphicon-play-wave-pause,#myLibraryListMusic .active .glyphicon-play-wave-pause{background-image:url(images/wave-pause.gif);width:10px;height:10px;margin:0px 6px 0px 8px;}
			#playListTable .active .music-index,#myLibraryListMusic .active .music-index{display:none}
			.playLibrary .glyphicon-play-wave{background-image:url(images/wave-dark.gif);width:12px;height:12px;float:right;background-size:cover}
			
			
			#p-body .title li{padding:10px;display:table-cell;text-align: center;width: 50%;float:left}
			#p-body .title{height:40px}
			#p-body .title a{text-decoration:none;color:#999;font-weight: 800}
			#p-body .title {border-bottom:2px solid #fff;}
			#p-body .title .active{background: #fff;border-top-left-radius: 2px;border-top-right-radius: 2px;}
			
			#p-body .title{margin: auto;width: 700px;padding: 0px}
			
			
			@media handle,only screen and (max-width:450px){
				body{min-width:300px;}
				#play-control{max-width:unset}
				#play{height:110px;}
				#playList{width: 100%;}#playListTable{margin:0px}
				#p-body .title{width: 100%;//padding-top:10px}
				#play-control a{top:10px;position: unset;margin: auto;}
				#play-control div{width:33.33%;position:relative;top:10px}
				#play-info{top:40px;left:unset}
				#volume{display:none;}
				#play-control, #play-info{float:unset;width:100%}
				#mp3-name{text-align:center}
				#jindu{position:relative;top:5px;width:100%;text-align:center;margin:auto;width:95%}
				#ex1Slider{width:65%;margin:auto;}
				#timeLineStart,#timeLineEnd{position:absolute}
				#timeLineStart{left:0px}
				#timeLineEnd{right:0px}
			}
			
			
			table tbody {display:block;	overflow-y:auto;}
			table thead, tbody tr {	display:table;	width:100%;	table-layout:fixed;}
			table thead {//	width: calc( 100% - 1em )}
			table thead th{ background:#ccc;}
			tbody tr:hover{color:#888}
			.table>tbody>tr>td{padding:8px 0px}
		</style>
		
	</head>
	<body>
		
		<div id='p-body' >
			<ul class='title' style="background:#eee">
				<li class='active'><a href="#musicList" @click="getMusic" data-toggle="tab">所有音乐</a></li>
				<li><a href="#myLibraryList" @click="resetLibrarySelected" data-toggle="tab">我的歌单</a></li>
			</ul>
				
			<div id="playList" class="tab-content">
				<div class="tab-pane" id="myLibraryList" >
					<div id='myLibraryListMenu' class="myLibraryList-box">
						<div style="background:#fff;overflow-y:auto;height:100%;padding-bottom:35px">
							<div v-for="rs,index in libraryList" class='libraryListMenu-item' v-bind:class="{active:index==activeLibraryId,playLibrary:index==playLibraryId}" @click="getLibraryListMusic(index);active(index)" >
								{{rs.libName}}
								<span class='glyphicon glyphicon-play-wave'></span>
							</div>
						</div>
						<div class="btn btn-default btn-block" style="position:absolute;bottom:0px;border-radius:0px;border-width:1px 0px 0px;" @click="showAddLibDialog">
							<a>
								<span class="glyphicon glyphicon-plus" ></span>新歌单
							</a>
						</div>
					</div>

					<div id='myLibraryListMusic' class="myLibraryList-box">
							<div v-for="rs,index in libraryMusicList" class='libraryListMusic-item music-item' v-bind:class="{active:rs.playStatus}" @click="play(index)">
								<dl>
									<span class="music-index">{{index+1}}</span>
									<span class='glyphicon glyphicon-play-circle'></span>
									<span class='glyphicon glyphicon-play-wave'></span>
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
									<div :id="rs.id" class=' music-item' @click='play(index)' v-bind:class="{active:rs.playStatus}">
										<span class='music-index'>{{index+1}}</span>
										<span class='glyphicon glyphicon-play-circle'></span>
									<span class='glyphicon glyphicon-play-wave'></span>
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
						<div id="volume" >
							<div id="volume-icon" ></div>
							<input id="volume-control" data-slider-id='volume-control' type="text" data-slider-min="0" data-slider-max="10" data-slider-step="0.1" data-slider-value="10"  />
						</div>
						
					</div>
				</div>
			</div>
			

		<script>
			var audio = $("audio")[0]
			var mySlider = $("#ex1").slider();
			var mySlider2 = $("#volume-control").slider();
			var index;
			
			//config list
		    var vm = new Vue({
		        el: '#p-body',
		        data: {
					activeLibraryId:null,//歌单激活active
					playLibraryId:null,
					playTab:1,
					viewTab:1,
					playId:null,
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
						this.playTab = this.viewTab;
						this.playList = this.viewList;
						this.playLibraryId = this.activeLibraryId;
						if(this.viewTab==1)
							vm.playLibraryId = null
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
								
								if(res.code==10000){
									$("#libraryList").modal('hide');
									vm.libraryList[vm.libraryIndex].musicList.push(vm.res.data[vm.musicIndex])
								//	console.log(vm.res)
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
								//	console.log(vm.libraryList);
						    	}else{
							    	alert(res.data.msg)
						    	}	
							  })
							  .catch(function (error) {
							    // 网络异常引发的错误
							});
				        }
			        },
					getLibraryListMusic(LibraryId){
						//基于歌单数组index获取歌单的音乐
						//this.libraryList : 歌单清单
						
						this.libraryMusicList = this.libraryList[LibraryId].musicList;//歌单id中的歌曲清单
						this.viewList = this.libraryList[LibraryId].musicList;
					},
					active(num){
						this.activeLibraryId = num;
						
						this.checkPlayStatus()
					},
					getMusic(){
						this.viewTab = 1;
						axios.get('api/getMusic.php')
						  .then(function (res) {
						  	//赋值
						  	if(res.data.code==10000){
						    	// 处理响应
								let len = res.data.data.length;
								//每个歌加入播放状态
								for(let i=0;i<len;i++){
									res.data.data[i].playStatus = false;
								}
							
								vm.viewList = res.data.data,								
								vm.res = res.data;
								vm.checkPlayStatus()
								
							//	console.log(vm.libraryList)
					    	}else{
						    	console.log(res.data)
					    	}	
						  })
						  .catch(function (error) {
						    // 网络异常引发的错误
						});

					},
					resetLibrarySelected(){
						this.viewTab = 2;
						this.activeLibraryId = null;
						this.libraryMusicList = null;
					},
					checkPlayStatus(){
						
						//清楚主歌单播放状态
						let len = this.viewList.length;
						for(let i=0;i<len;i++){
							this.viewList[i].playStatus = false;
						}
						//清楚歌单中歌曲播放状态
						let Llen = this.libraryList.length
						for(let i=0;i<Llen;i++){
							
							let LMlen = this.libraryList[i].musicList.length
							for(let j=0;j<LMlen;j++){
								this.libraryList[i].musicList[j].playStatus = false;
							}
						}
						//为播放的歌曲添加播放状态wave.gif
						if(this.viewTab==1&&this.playTab==1){
							this.viewList[this.playId].playStatus = true;
							
						}else if(this.viewTab==2&&this.playTab==2){
							if(this.activeLibraryId==this.playLibraryId){
								this.libraryMusicList[this.playId].playStatus = true;
							}
						}
					}
			        
		        },     
				mounted: function(){
						this.getMusic();
						//获取歌单清单及其歌曲清单
						axios.get('api/getLibraryList.php')
						  .then(function (res) {
						  	//赋值
						  	if(res.data.code==10000){
						    	// 处理响应
								vm.libraryList = res.data.data;
							//	console.log(res.data)
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
				
				$("#play-info").css('width',window.screen.width-300);
				
				var vol;
				$("#tbody").css('height',(document.documentElement.clientHeight-210))
				$("#myLibraryList").css('height',(document.documentElement.clientHeight-190))
				
				if($(window).width()>=700){
					$("#play-info").css("left",$("#play-control").css("width"))
				}
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
				mySlider2.bind('slideStop',function(res){
				//	console.log(res.value)
					audio.volume = res.value/10;
					$("#volume-icon").css("background-position-y","-295px");
				
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
				
				$("#volume-icon").on('click',function(){
					console.log('vol : ',vol);
					console.log('audio.volume : ',mySlider2.slider('getValue'));
					if(mySlider2.slider('getValue')==0){
						audio.volume = (vol/10).toFixed(1);
						mySlider2.slider('setValue', vol);
						
						$(this).css("background-position-y","-295px");
					}else{
						vol = mySlider2.slider('getValue');
						audio.volume = 0;
						mySlider2.slider('setValue', 0);
						
						$(this).css("background-position-y","-313px");
					}
					
					
					
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
				console.log("playId "+id);
				vm.playId = id;
				//标记播放的歌在主单还是歌单，1为主单，2为歌单
			
				index = id;
				data = vm.playList[id];
				audio.src = data.audioUrl;
				
				audio.play();
				$("#mp3-name").html(data.title+" —— "+data.author);
				audio.addEventListener("timeupdate",listen);
				$("#playBtn").removeClass('pauseBtn');
				//刷新播放状态标记
				vm.checkPlayStatus();
				$(".glyphicon-play-wave-pause").addClass('glyphicon-play-wave');
				$(".glyphicon-play-wave").removeClass('glyphicon-play-wave-pause');
				
			}		
			
			
			var playFlag = 1;
			$("#playBtn").click(function(){
				
				if(vm.playId==null){
					playFlag = 0;
					vm.play(0);
				}
				if(playFlag == 1){
					audio.pause()
					$("#playBtn").addClass('pauseBtn');
					$(".glyphicon-play-wave").addClass('glyphicon-play-wave-pause');
					$(".glyphicon-play-wave-pause").removeClass('glyphicon-play-wave');
					playFlag = 0;
				}else{
					audio.play()
					$("#playBtn").removeClass('pauseBtn');					
					$(".glyphicon-play-wave-pause").addClass('glyphicon-play-wave');
					$(".glyphicon-play-wave").removeClass('glyphicon-play-wave-pause');
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
		$url = "/bbs/login.php?openid=$openid&dir=$address"; 
		Header("Location:$url");
	}
?>