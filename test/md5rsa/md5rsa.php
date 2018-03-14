<?php

	require_once __DIR__ . '/../../vendor/autoload.php';

	//渠道数据

	$chennel=array(
		'partner_id'=>'2600833041',
		'name'=>'aaaaa',
	);
	$prikey = 'file/rsa_private_key.pem' ;
	$pubkey = 'file/rsa_public_key.pem' ;

	$md5rsa = new \Phplib\Md5Rsa($prikey, $pubkey);
	$chennel = $md5rsa->sendAction($chennel);


