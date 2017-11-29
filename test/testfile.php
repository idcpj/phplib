<?php
	require_once __DIR__ . '/../../vendor/autoload.php';


	/**
	 * 文件下载demo  - 自定义输出名称
	 */
	CFile\File::downloadFile('file/01.png', '01');


	/**
	 * 文件下载demo  - 源文件名
	 */
	CFile\File::downloadFile('file/01.png');


	CFile\File::createZip(['file/01.png'], 'ok.zip');

