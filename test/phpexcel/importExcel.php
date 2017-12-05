<?php

	//把excel 转数组

	require_once __DIR__ . '/../../vendor/autoload.php';

	$file ='../res/a.xls';
	$res = \Phplib\PHPExcel::excelConvertData($file);
	print_r($res);
