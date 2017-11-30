<?php
	/*1.抽象建造者
	 *2.具体建造者
	 *3.指挥者
	 *4.产品角色
	 *
	 * 一层实例一层
	 *
	 */

	//
	class Person{
		public $age;
		public $speed;
		public $knowledge;
	}

	/*
	 * 抽象建造者
	 */

	abstract class Builder{
		public $_person;

		public abstract function setAge();

		public abstract function setSpeed();

		public abstract function setKnowledge();

		public function __construct(Person $person){
			$this->_person = $person;
		}

		public function getPerson(){
			return $this->_person;
		}
	}

	//老人-具体造者
	class OlderBuilder extends Builder{
		public function setAge(){
			$this->_person->age = 70;
		}

		public function setSpeed(){
			$this->_person->Speed = "low";
		}

		public function setKnowledge(){
			$this->_person->knowledge = 'more';
		}
	}

	//小孩-具体造者
	class ChildBuilder extends Builder{
		public function setAge(){
			$this->_person->age = 10;
		}

		public function setSpeed(){
			$this->_person->Speed = "fast";
		}

		public function setKnowledge(){
			$this->_person->knowledge = 'litte';
		}
	}

	//指挥者
	class Director{
		private $_buider;

		public function __construct(Builder $builder){
			$this->_buider = $builder;
		}

		public function built(){
			$this->_buider->setAge();
			$this->_buider->setSpeed();
			$this->_buider->setKnowledge();
		}
	}

	//实例化一个长者
	$personC = new  OlderBuilder(new Person);
	//实例化一个建造指挥者
	$directorC = new Director($personC);
	//指挥建筑
	$directorC->built();
	$older = $personC->getPerson();
	var_dump($older);