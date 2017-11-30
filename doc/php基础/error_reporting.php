<?php
	/**
	 * 1.*设置错误级别
	 */
	error_reporting(E_ALL);//显示全部错误
	error_reporting(E_ALL^E_NOTICE);//显示全部错误除了注意级别的错误
	error_reporting(0);//屏蔽所有错误 除了Parse error(语法解析错误)
	ini_set('error_reporting', 0);//同上

	/**
	 *2. 用户设置错误
	 */
	if ($divisor == 0) {
		trigger_error("Cannot divide by zero", E_USER_ERROR);//致命错误,程序会终止
		trigger_error("Cannot divide by zero", E_USER_NOTICE);
		trigger_error("Cannot divide by zero", E_USER_WARNING);
	}

	/**
	 * 3.将错误日志保存到文件中
	 * 也可以在php.ini中设置
	 */
	ini_set('log_errors', 'on');//若php.ini中为开启.可在此开启
	ini_set('error_log', 'error.log');//若php.ini未设置路径,可在此设置
	ini_set('display_errors', 'off');//隐藏错误在浏览器中
	error_reporting(-1);//显示所有错误
	echo $a;//自动存入error.log

	if(1 !=2){
		$message="通过对比发现1不等2".date('Y-m-d H:i:s',time());
		error_log($message);  //手动存入error.log
	}

	/**
	 * 4.将错误信息发送到邮箱
	 */
	error_log("当前产生致命错误,",1,"260083304@qq.com");//测试失败

	/**
	 * 5.set_error_handler()
	 * 设置用户的错误信息,替换官方
	 */
	function customError($errorno, $errmsg, $file, $line){
		echo "<b>错误代码:</b>[{$errorno}] {$errmsg}<br/>".PHP_EOL;
		echo "<b>错误行号:</b>[{$file}] {$line}<br/>".PHP_EOL;
		echo "<b>PHP版本:</b>[".PHP_VERSION."] ".PHP_OS."<br/>".PHP_EOL;
	}
	set_error_handler('customError');
	echo $test;
	restore_error_handler();//还原
	echo $test;

	/**
	 * 6.程序错误终端中断前最后执行的函数
	 * Array
		(
		[type] => 1
		[message] => Call to undefined function imooc()
		[file] => D:\phpStudy\WWW\demo\test.php
		[line] => 22
		)
	 */
	function foo(){
		echo "您的程序意外终止";
		echo "<pre>";
		print_r(error_get_last());//获取最后错误信息
		echo "<pre>";

	}
	register_shutdown_function('foo');
	echo imooc();

	/**
	 * 7.异常处理
	 */
	try{
		$n=0;
		if($n===0){
			throw new Exception("不能为零");
		}
		$num=3/$n;
	}catch(Exception $e){
		echo $e->getMessage()."<br/>";
	}


	try{
		$pod = new PDO('mysql:dbname=test;host=127.0.0.1','root','root1');
		var_dump($pod);
	}catch(PDOException $e){
		echo $e->getMessage();
	}

	 /**
	  * 8.自定义异常处理器
	  */
	function exceptionHandler1($e){
		echo '自定义的异常处理器1';
		echo '异常信息:'.$e->getMessage();
	}
	function exceptionHandler2($e){
		echo '自定义的异常处理器2';
		echo '异常信息:'.$e->getMessage();
	}

	set_exception_handler('exceptionHandler1');
	set_exception_handler('exceptionHandler2');//覆盖上一个
	restore_exception_handler();//取消exceptionHandler2,
	throw new Exception('this is a test');//程序不往下执行











