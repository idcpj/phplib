<?php
	header("Content-type:text/html;charset=utf8");
	require __DIR__.'/lib/User.php';
	require __DIR__.'/lib/Article.php';


	/*连接数据表*/
	$pdo= require __DIR__.'/lib/db.php';

	$user = new User($pdo);
	$article = new Article($pdo);
	$user = $user->login('cpj8', '1234612');
	//print_r($user->register('cpj16', '1234612'));

	//print_r($user);
	//print_r($article->add("你好", '这是内容测试', 'cpj', $user['user_id']));
	//print_r($article->del(10, $user['user_id']));
	//print_r($article->edit(12, $user['user_id']));
	//print_r($article->fetOne(12));
	//print_r($article->edit("我是修改的百题","我是修改的内哦那个","我是作者",12,$user['user_id']));
	print_r($article->listForPage($user['user_id'],2));