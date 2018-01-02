<?php

	require_once '../../src/function/common.php';

	$data[] = array('customer_name' => '小李', 'money' => 12, 'distance' => 2, 'address' => '长安街C坊');
	$data[] = array('customer_name' => '王晓', 'money' => 30, 'distance' => 10, 'address' => '北大街30号');
	$data[] = array('customer_name' => '赵小雅', 'money' => 89, 'distance' => 6, 'address' => '解放路恒基大厦A座');
	$data[] = array('customer_name' => '小月', 'money' => 150, 'distance' => 5, 'address' => '天桥十字东400米');
	$data[] = array('customer_name' => '李亮亮', 'money' => 45, 'distance' => 26, 'address' => '天山西路198弄');
	$data[] = array('customer_name' => '董娟', 'money' => 67, 'distance' => 17, 'address' => '新大南路2号');



	//以距离排序
	$a = arraySort($data, 'distance', SORT_DESC);
	print_r($a);


