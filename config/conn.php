<?php
	session_start();
	
	//error_reporting(E_ALL & ~E_NOTICE); 
		
	$conn = @ mysql_connect("localhost", "root", "mm") or die("数据库链接错误,conn"); 
	mysql_select_db("form", $conn); 
	
	mysql_query("SET CHARACTER_SET_RESULTS=UTF8'");
	mysql_query("SET CHARACTER SET UTF8"); 
	mysql_query("set names 'utf8'"); 
	
?>