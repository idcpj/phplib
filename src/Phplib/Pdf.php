<?php

/**

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
 *
 */



 namespace Phplib;


 use TCPDF;

 /**
  *
  * 由于中文乱码的问题,
  * Class Pdf
  * @package Phplib
  */
 class Pdf {
	 private $pdf;

	 public function __construct(){
		 $this->pdf = new Tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	 }

	 /**
	  * 设置页眉
	  * @param        $headerTtitle     页眉标题
	  * @param        $headerCon        页眉内容
	  * @param int    $lw               页面距离左边距离
	  * @param string $img              页眉logo
	  * @return $this
	  */
	 public function setHeader($headerTtitle,$headerCon, $lw=100,$img=''){

		 $this->pdf->SetHeaderData($img, $lw, $headerTtitle, $headerCon, array(0, 0, 255), array(0, 64, 128));
		 return $this;
	 }

	 /**
	  * 设置内容
	  * @param        $html  html内容
	  * @param string $title    标签栏标题
	  * @return $this
	  */
	 public  function htmlToPdf($html,$title='pdf'){

		 // set document information
		 $this->pdf->SetCreator(PDF_CREATOR);
		 $this->pdf->SetAuthor('Nicola Asuni');
		 $this->pdf->SetTitle($title);
		 // $this->pdf->SetSubject('TCPDF Tutorial');
		 // $this->pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		 // set default header data
		 $this->pdf->setFooterData(array(0,64,0), array(0,64,128));

		 // set header and footer fonts
		 $this->pdf->setHeaderFont(Array('stsongstdlight', '', PDF_FONT_SIZE_MAIN));
		 $this->pdf->setFooterFont(Array('stsongstdlight', '', PDF_FONT_SIZE_DATA));

		 // set default monospaced font
		 $this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		 // set margins
		 $this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		 $this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		 $this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		 // set auto page breaks
		 $this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		 // set image scale factor
		 $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		 // set default font subsetting mode
		 $this->pdf->setFontSubsetting(true);


		 if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			 require_once(dirname(__FILE__).'/lang/eng.php');
			 $this->pdf->setLanguageArray($l);
		 }
		 // Add a page
		 $this->pdf->AddPage();

		 // set text shadow effect
		 $this->pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
		 $this->pdf->SetFont('stsongstdlight');
		 // Print text using writeHTMLCell()
		 $this->pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		 return $this;
	}

	 public function addImg($imgPath,$x=100,$y=100,$width=50,$height=50){
		 $pathInfo = pathinfo($imgPath);
		 $this->pdf->Image($imgPath, $x, $y, $width, $height, $pathInfo['extension']);
		 return $this;
	}

	//直接展示
	 public function showPdf($title){
		 $this->pdf->Output($title.'.pdf', 'I');
	 }

	 //直接下载
	 public function downPdf($title){
		 $this->pdf->Output($title.'.pdf', 'D');
	 }

	 //保存到服务器
	 public function savePdf($path){
		 $this->pdf->Output($path.'.pdf', 'F');
	 }


 }