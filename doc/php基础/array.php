<?php

	//<editor-fold desc=" array_map 对数组中的每个元素进行处理">
	function arrpus(&$var){
		return $var+2;
	}
	$a=array(1,2,3,4,5);
	return  $b =  array_map('arrpus',$a);
	print_r($b);
	//</editor-fold>

	//<editor-fold desc="array_walk 的用法一,必须加引用,才能改变原来数组,array_map,只能取值,不能取键名">
	$a = array(1,2,3,4,5,6,7);
	function keypus(&$item,&$key){
		$item = $item+$key;
	}
	array_walk($a,'keypus');
	print_r($a);
	//</editor-fold>

	//<editor-fold desc="array_walk 每个元素值都加4">
	$a = array(1,2,3,4,5,6,7);
	function numpus(&$item,&$key,$num){
		$item = $item+$num;
	}
	array_walk($a,'numpus',4);
	print_r($a);
	//</editor-fold>

	//<editor-fold desc="array_filter 得到奇数">
	$a = array(1,2,3,4,5,6,7);
	function odd($val){
		if($val%2==1){
			return $val;
		}
	}
	$b = array_filter($a,'odd');
	print_r($b);
	//</editor-fold>