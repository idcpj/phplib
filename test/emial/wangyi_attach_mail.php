<?php


	require_once __DIR__ . '/../../vendor/autoload.php';

	$config['smtp']='smtp.163.com';        // smtp
	$config['username']='157****7105@163.com';    /// 账号
	$config['password']='a137************';    // //密码  注意: 163和QQ邮箱是授权码；不是登录的密码
	$config['from_name']='cpj';  //发件人
	$config['smtp_secure']='';   // 链接方式 如果使用QQ邮箱；需要把此项改为  ssl
	$config['port']='25';    // 端口网易25 如果使用QQ邮箱；需要把此项改为  465

	$address ='260083304@qq.com';
	$subject ='测试邮箱';
	$content ='测试内容';
	$path ='../res/01.png'; //附件地址

	try{
		$emial  = new  \Phplib\Email($config);
		$emial->addAttach($path)->sendEmail($address, $subject, $content);
		 print_r('success');
	} catch(Exception $e){
		 print_r($e->getMessage());
	}

