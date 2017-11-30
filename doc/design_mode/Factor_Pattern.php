<?php

	//工厂类简单实例
	class Memcache{
		public function set($var, $val){
			//code
		}

		public function get($var){
			//code
		}
	}

	class Redis{
		public function set($var, $val){
			//code
		}

		public function get($var){
			//code
		}
	}

	class Cache{
		public static function factory(){
			return new Memcache();
		}
	}

	//无需关心是实例化了什么缓存类型,下次想换为radis 直接修改factory为 new Radis
	$obj = Cache::factory();

	/*工厂类*/

	class Factor{
		static function craeteDB(){
			return new DB();
		}
	}

	/*数据库类*/

	class DB{
		public function __construct(){
			echo __CLASS__ . PHP_EOL;
		}
	}

	/*添加实例*/
	//$db = Factor::craeteDB();

	/**
	 * 实现运算器
	 */
	abstract class Operation{
		abstract public function getVal($I, $j);
	}

	class Add extends Operation{
		public function getVal($i, $j){
			return $i + $j;
		}
	}

	class Sub extends Operation{
		public function getVal($i, $j){
			return $i - $j;
		}
	}

	/*
	 * 通过对符号的判断来决定调用什么类
	 * */

	class  FactorObj{
		private static $operation;

		static public function createOperation($operation){
			switch($operation){
				case "+":
					self::$operation = new  Add();
					break;
				case "+":
					self::$operation = new  Sub();
					break;
			}

			return self::$operation;
		}
	}

	$counter = FactorObj::createOperation("+");
	echo $counter->getVal(7, 2);