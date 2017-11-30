<?php
	header('Content-type:text/html;charset:utf-8');
	//大括号和中括号等价


	//<editor-fold desc="输出字符串">
	$str ="abcde";
	echo $str{0};//a
	//</editor-fold>

	//<editor-fold desc="替换">
	$str{1}='m';
	echo $str; //amcde
	//</editor-fold>

	//<editor-fold desc="追加">
	$str[5]='f';
	echo $str;//abcdef
	//</editor-fold>

	//<editor-fold desc="输出中文">
	$strc="你好";
	echo $strc{0};
	echo $strc{1};
	echo $strc{2};//输出你
	echo  strlen($strc);
	//</editor-fold>


	//<editor-fold desc="随机字符串">
	echo $str{mt_rand(0,strlen($str)-1)};
	//</editor-fold>

	//<editor-fold desc="获取字符串类型">
	echo gettype($str);//string
	//</editor-fold>

	//<editor-fold desc="永久转换">
	$var = 123;
	settype($var, 'string');
	var_dump($var);//string->3
	//</editor-fold>

	//<editor-fold desc="字符串转数字">
	echo 3+'2cpj';//5
	echo 3+'2e2';//203  科学计数法
	//</editor-fold>



