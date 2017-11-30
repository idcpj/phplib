<?php
	//装饰器模式
	/*
	class Person{
		public function clothes(){
			echo "长衫".PHP_EOL;
		}
	}
	*/

	/*新方法的接口*/

	interface Decorater{
		public function beforeDrow();

		public function afterDrow();
	}

	/*新接口的类*/

	class Ast implements Decorater{
		public function beforeDrow(){
			echo "T寻" . PHP_EOL;
		}

		public function afterDrow(){
			echo "宇航服" . PHP_EOL;
		}
	}

	/*可创建多个新接口的类*/

	class ABC implements Decorater{
		public function beforeDrow(){
			echo "hello" . PHP_EOL;
		}

		public function afterDrow(){
			echo "word" . PHP_EOL;
		}
	}

	/*
	 * 新的Person类
	 */

	class Person{
		protected $decorators = array();

		//添加
		public function addDec(Decorater $decorater){
			$this->decorators[] = $decorater;
		}

		//实现接口方法
		public function beforeDraw(){
			foreach($this->decorators as $decorator){
				$decorator->beforeDrow();
			}
		}

		public function afterDraw(){
			$decoratos = array_reverse($this->decorators);
			foreach($decoratos as $decorato){
				$decorato->afterDrow();
			}
		}

		//在原方法中加调用新方法
		public function clothes(){
			$this->beforeDraw();
			echo "长衫" . PHP_EOL;
			$this->afterDraw();
		}
	}

	//创建实例
	$PersonObj = new Person;
	$PersonObj->addDec(new ABC);
	$PersonObj->clothes();