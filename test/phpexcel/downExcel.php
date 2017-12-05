<?php

	require_once __DIR__ . '/../../vendor/autoload.php';

	$xlsName = "User";
	$xlsCell  = array(
		array('id','账号序列'),
		array('name','名字'),
		array('plate','车牌'),
		array('amount','保费'),
		array('createtime','创建时间'),

	);
	$xlsData[] = array(
		'id'=>1,
		'name'=>'cpj',
		'plate'=>'zheasd',
		'amount'=>'2000',
		'createtime'=>'asdasd',
	);
	$xlsData[] = array(
			'id'=>2,
			'name'=>'cpj',
			'plate'=>'zheasd',
			'amount'=>'2000',
			'createtime'=>'asdasd',
		);

	try{
		\Phplib\PHPExcel::exportExcel($xlsName, $xlsCell, $xlsData);
	} catch(Exception $e){
		die($e->getMessage());
	}
