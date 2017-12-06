<?php


	require_once __DIR__ . '/../../vendor/autoload.php';

	$config['smtp']='smtp.qq.com';        // smtp
	$config['username']='260083304@qq.com';    /// 账号
	$config['password']='****';    // //密码  注意: 163和QQ邮箱是授权码；不是登录的密码
	$config['from_name']='cpj';  //发件人
	$config['smtp_secure']='ssl';   // 链接方式 如果使用QQ邮箱；需要把此项改为  ssl
	$config['port']='465';    // 端口网易25 如果使用QQ邮箱；需要把此项改为  465
	
	$address ='15726817105@163.com';
	$subject ='测试邮箱';
	$content ='测试内容';

	try{
		Phplib\Email::sendEmail($address, $subject, $content, $config);
		print_r('success');
	} catch(Exception $e){
		print_r($e->getMessage());
	}

