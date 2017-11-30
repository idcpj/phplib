<?php
	/*连接数据库
	*返回数据句柄
	*/
	require __DIR__.'/ErrorCode.php';

	class User{

		private $_db;

		public function __construct($_db)
		{
			$this->_db=$_db;
		}

		//登录
		public function login($username,$password){
			if(empty($username)){
				throw new Exception("用户名不能为空",ErrorCode::USERNAME_CANNOT_EMPTY);
			}
			if(empty($password)){
				throw new Exception("密码不能为空",ErrorCode::PASSWORD_CANNOT_EMPTY);
			}
			$sql="SELECT * FROM `user` WHERE `username`=:username AND `password`=:password";
			$stmt=$this->_db->prepare($sql);
			$password=$this->_md5($password);
			$stmt->bindParam(':username',$username,PDO::PARAM_STR);
			$stmt->bindParam(':password',$password,PDO::PARAM_STR);
			$stmt->execute();
			$user=$stmt->fetch(PDO::FETCH_ASSOC);
			if(empty($user)){
				throw new Exception("用户名或密码错误",ErrorCode::USER_OR_PASSWORD_ERROR);
			}
			unset($user['password']);
			return $user;
		}

		//注册
		public function register($username,$password){
			if(empty($username)){
				throw new Exception("用户名不能为空",ErrorCode::USERNAME_CANNOT_EMPTY);
			}
			if($this->isUsernameExists($username)){
				throw new Exception("用户名已经存在",ErrorCode::USERNAME_EXISTS);//常量用"::"引用
			}
			if(empty($password)){
				throw new Exception("密码不能为空",PASSWORD_CANNOT_EMPTY);
			}
			$sql="INSERT INTO `user`(`username`,`password`,`created_at`) VALUES (:username,:password,now())";
			$stmt = $this->_db->prepare($sql);
			$created_at=time();
			$password=$this->_md5($password);
			$stmt->bindParam(':username',$username,PDO::PARAM_STR);
			$stmt->bindParam(':password',$password,PDO::PARAM_STR);
			//$stmt->bindParam(':created_at',$created_at,PDO::PARAM_INT);
			if(!$stmt->execute()){
				throw new Exception("注册失败",ErrorCode::REGISTER_FAIL);
			}
			return [
				'user_id'=>$this->_db->lastInsertId(),
			    'username'=>$username,
			    'created_at'=>$created_at,
			];

		}

		//加密
		private function _md5($password,$str='pre'){
			return md5($str.$password);
		}

		//检测用户名是否存在
		private function isUsernameExists($username){
			$sql="SELECT * FROM `user` WHERE `username`=:username";
			$stmt=$this->_db->prepare($sql);
			$stmt->bindParam(':username',$username);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return !empty($result);
		}


	}

