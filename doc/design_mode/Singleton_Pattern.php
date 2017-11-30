<?php
	//单例模式 例子一
	class AB{
		private static $_instance=null;
		public function __clone(){}
		public function __construct(){}
		public static function getInstance(){
			if(!(self::$_instance instanceof self)){
				self::$_instance=new self();
			}
			return self::$_instance;
		}
	}
	$A = Cache::getInstance();
	$B = Cache::getInstance();
	$C = Cache::getInstance();
	//例子二
	class DB{
		private $link ;
		private static $_instance;
		private $dsn = "mysql:host=127.0.0.1;dbname=test";
		private $username = 'root';
		private $password = 'root';
		//连接数据库
		private function __construct(){
			try{
				$this->link = new PDO($this->dsn,$this->username,$this->password);
				$this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e ){
				die("连接失败:".$e->getMessage());
			}
			return $this->link;
		}
		//防止被克隆
		private function __clone(){}
		//获取实例
		public static function getInstance(){
			if(!(self::$_instance instanceof self)){
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		//query
		public function query($sql){
			return $this->link->query($sql);
		}
		//获取一行
		public function fetchOne($sql){
			$result= $this->query($sql);
			return $result->fetch(PDO::FETCH_ASSOC);
		}
		//获取全部
		public function fetchAll($sql){
			$result = $this->query($sql);
			return $result->fetchAll(PDO::FETCH_ASSOC);
		}
		//获取记录条数
		public function counts($sql){
			$result = $this->query($sql);
			return $result->rowCount();
		}
	}
	$link = DB::getInstance();
	$sql = "select * from `cmf_auth_rule` ";
	print_r($link->counts($sql));