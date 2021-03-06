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
		<script src="/js/bootstrap.min.js"></script>
		<style>
			body{background-image:url(images/51206f4be3528.jpg);word-break: break-word}
			#play{width:100%;height:80px;position:fixed;bottom:0px;}
			#play-control{width:300px;display:inline-block;position:absolute;top:0px}
			#play-info{width:1200px;display:inline-block;position: absolute;  left: 300px;  top: 0px;}
			#play-control a{background-image:url(images/icon.png);background-repeat:no-repeat;border:0px solid red;position:relative;width:30px;height:30px;display:block;top:28px}
			#play-control div{display:inline-block;}
			#prevBtn{left:30px;background-position:0px -90px}
			#prevBtn:hover{background-position:-30px -90px}
			#playBtn{left:60px;background-position:0px -30px}
			#playBtn:hover{background-position:-30px -30px}
			#play-control .pauseBtn{background-position:0px 0px}
			#play-control .pauseBtn:hover{background-position:-30px 0px}
			#nextBtn{left:90px;background-position:-2px -60px}
			#nextBtn:hover{left:90px;background-position:-30px -60px}
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
			#playListTable{margin-top: 30px;font-size: 1.0em}.music-item:hover{//color: #888;cursor: pointer}
			.music-item:hover #music-index{display:none}
			.music-item:hover .glyphicon-play-circle{display:inline-block}
			.music-option{background-image:url(images/icon.png);background-repeat:no-repeat;background-position:0px -296px;width:20px;height:18px;display:block}
			#playListTable thead{font-weight:800}
			#music-index{margin: 0px 10px;}
			.glyphicon-chevron-down:hover{color:#ddd}
			.glyphicon-play-circle{margin: 0px 12px 0px 6px;display:none}
			#play-background{background:#666666;opacity: 0.6;height:100%}
			.open>.dropdown-menu{right:-8px;border:1px solid #eee;min-width:80px;left:unset}
			@media handle,only screen and (max-width:450px){
				#play{height:110px;}
				#playList{width: 100%;padding: 10px;}#playListTable{margin:0px}
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
			
			table tbody {display:block;	overflow-y:auto;}
			table thead, tbody tr {	display:table;	width:100%;	table-layout:fixed;}
			table thead {//	width: calc( 100% - 1em )}
			table thead th{ background:#ccc;}
		</style>
		
	</head>
	<body>
		
		<div id="playList">
			<table id='playListTable' class="table table-hover-">
				<thead>
					<tr>
						<td>歌曲</td>
						<td width='80'>演唱者</td>
						<td width='60'></td>
					</tr>
				</thead>
				<tbody id='tbody'>
				</tbody>
			</table>
		</div>
	
	
	
		<div id="play">
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
					<div id="volume-icon"><input id="volume" data-slider-id='volume' type="text" data-slider-min="0" data-slider-max="10" data-slider-step="0.1" data-slider-value="5"  /></div>
					
				</div>
			</div>
		</div>
		
		<audio src='' ></audio>
		<script>
			var audio = $("audio")[0]
			var mySlider = $("#ex1").slider();
			var mySlider2 = $("#volume").slider();
			var list = [],index;
			
			$(document).ready(function(){
				console.log(document.documentElement.clientHeight)
				$("#tbody").css('height',(document.documentElement.clientHeight-190))
				// With JQuery
				$('#ex1').slider({
					formatter: function(value) {
						return FormatTime(value);					
					}
				});
				//select the item to trigger play
				$(document).on('click',".music-item",function(){
					var id = $(this).parents("tr").attr('id').replace('m','')
					playMusic(id);					
				})
				$(document).on('click',".addToList",function(){
					var id = $(this).parents("tr").attr('id').replace('m','')
					console.log(list[id]);					
				})	

					
				$("#prevBtn").click(function(){
					if(index==0)
						index = list.length; 
					playMusic(--index);
				})
				$("#nextBtn").click(function(){
					if(index==(list.length-1))
						index = -1;
					playMusic(++index);
				})	
				//
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
				mySlider.bind('slideStop',function(res){
				//	console.log(res.value)
					audio.addEventListener("timeupdate",listen)
					audio.currentTime = res.value
				})
				//监听拖拽
				mySlider.bind('slide',function(res){
				//	console.log(res.value)
					audio.removeEventListener('timeupdate',listen)
				})
				getMusic();
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
		
		
			function getMusic(){
				$.ajax({
					url:'api/getMusic.php?',
					dataType:'json',
					success:function(res){
						console.log(res)
						if(res.code==10000){
							
							var len = res.data.length;
							var h = '';
							list = res.data
							
							for(var i=0;i<len;i++){
								h += "<tr id='m"+ i +"'><td>";
								h += "<div class=' music-item' ><span id='music-index'> "+(i+1)+" </span><span class='glyphicon glyphicon-play-circle'></span><span>"+list[i].title+"</span></div>";
								h += "</td><td width='80'>";
								h += "<span>"+list[i].author+"</span>";
								h += "</td><td width='60'>";
								h += "<div class='dropdown'><span class='glyphicon glyphicon-chevron-down'  data-toggle='dropdown'></span><ul class='dropdown-menu fright' role='menu' aria-labelledby='myTabDrop1'><li><a class='addToList' tabindex='-1' data-toggle='tab'>加入到歌单</a></li><li><a  tabindex='-1' data-toggle='tab'>添加新歌单</a></li></ul></div>";
								h += "</td></tr>";
							}
							$("#tbody").append(h)
							
							
						}else{
							alert("鉴权失败！");
						}
						
					}
				})
			}
			function playMusic(id){
				console.log(id)
				index = id;
				
				data = list[id];
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
			//	console.log(audio.duration)
			//	console.log(audio.currentTime)
			})
			
			function replaceEmptyItem(arr){
				for(var i=0,len=arr.length;i<len;i++){
					if(!arr[i]|| arr[i]==''){
						arr.splice(i,1);
						len--;
					}
				}
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