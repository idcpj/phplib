<?php

/*
	==============================
	TCPDF不能保存中文文件名的解决方法
	==============================

1、注释以下代码，大约在7565-7568行：

if ($dest[0] != 'F') {
	$name = preg_replace('/[\s]+/', '_', $name);
	$name = preg_replace('/[^a-zA-Z0-9_\.-]/', '', $name);
}

2、搜索该方法代码，替换如下代码，大约分别在7639、7670、7693、7718行。
	header('Content-Disposition: attachment; filename="'.basename($name).'"');
	替换为
	header('Content-Disposition: attachment; filename="'.$name.'"');

 */

	//把hmtl传成pdf

	require_once __DIR__ . '/../../vendor/autoload.php';
	date_default_timezone_set('PRC');


	$html = <<<EOD
<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
<i>This is the first example of TCPDF library.</i>
<p>This text is printed using th啊飒飒飒飒 测试 e  <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
<p>Please check the source code documentation and other examples for further information.</p>
<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
EOD;


	$pdf = new \Phplib\Pdf();

	//带页眉
	// $pdf->setHeader('测试测试标题','内容测试内容测试内容')->htmlToPdf($html)->showPdf('2017');


	//不带页眉 -直接展示
	// $pdf->htmlToPdf($html)->showPdf('2017');


	//下载pdf
	$pdf->htmlToPdf($html)->downPdf('201711中文测试');


	//保存文件
	// $path = __DIR__ .'2017';
	// $pdf->htmlToPdf($html)->savePdf($path); //路径必须是绝对路径


	//带图片
	// $path  =__DIR__.'/../res/01.png';
	// $pdf->htmlToPdf($html)->addImg($path,100,100,50,50)->showPdf($path); //路径必须是绝对路径