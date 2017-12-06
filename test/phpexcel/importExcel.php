<?php

	//把excel 转数组

	require_once __DIR__ . '/../../vendor/autoload.php';

	$file ='../res/a.csv';
	$file ='../res/a.xls';
	$res = \Phplib\PHPExcel::excelConvertData($file,true);//true 为空也过滤
	print_r($res);
