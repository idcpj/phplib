<?php
	require_once __DIR__ . '/../vendor/autoload.php';


	/**
	 * 文件下载demo  - 自定义输出名称
	 */
	\Phplib\File::downloadFile('file/01.png', '01');


	/**
	 * 文件下载demo  - 源文件名
	 */
	\Phplib\File::downloadFile('file/01.png');


	/**
	 * 压缩文件
	 */
	$res = array(
		'../demo/api.php',
		'../demo/db.php',
	);
	\Phplib\File::createZip($res,'data/upload/cc.zip');

