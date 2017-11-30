<?php

	class Article{
		private $_db;

		public function __construct($_db)
		{
			$this->_db=$_db;
		}

		//发表文章
		public function add($titler,$content,$author,$user_id){
			if(empty($titler)){
				throw new Exception("文章标题不能为空");
			}
			if(empty($content)){
				throw new Exception("内容不能为空");
			}
			if(empty($author)){
				throw new Exception("作者不能为空");
			}
			if(empty($user_id)){
				throw new Exception("id不能为空");
			}
			$sql="INSERT INTO `article`(`titler`,`content`,`user_id`) VALUES (:titler,:content,:user_id)";
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':titler',$titler,PDO::PARAM_STR);
			$stmt->bindParam(':content',$content,PDO::PARAM_STR);
			$stmt->bindParam(':user_id',$user_id,PDO::PARAM_INT);
			$stmt->execute();
			$article = $this->_db->lastInsertId(PDO::FETCH_ASSOC);
			if(empty($article)){
				throw new Exception("文章添加失败");
			}
			return $article;
		}

		//编辑
		public function edit($titler,$content,$article_id,$user_id){
			if(empty($titler)){
				throw new Exception("文章标题不能为空");
			}
			if(empty($content)){
				throw new Exception("内容不能为空");
			}

			if(empty($article_id)){
				throw new Exception("文章id不能为空");
			}
			if(empty($user_id)){
				throw new Exception("用户id不能为空");
			}
			$res_use_id=$this->fetOne($article_id)['user_id'];
			if($res_use_id !=$user_id){
				throw new Exception("您没有权限修改");
			}
			$sql="UPDATE `article` set `titler`=:titler,`content`=:content,`author`=:author WHERE `article_id`=:article_id ";
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':titler',$titler,PDO::PARAM_STR);
			$stmt->bindParam(':content',$content,PDO::PARAM_STR);
			$stmt->bindParam(':author',$author,PDO::PARAM_STR);
			$stmt->bindParam(':article_id',$article_id,PDO::PARAM_INT);
			if($stmt->execute()){
				throw new Exception("更新文章失败");
			}
			return [
				'titler'   => $titler,
				'content'  => $content,
				'author'   => $author,
				'$article' => $article_id,
			];


		}

		//删除文章
		public function del($article_id,$user_id){
			if(empty($article_id)){
				throw new Exception("文章id不能为空");
			}
			if(empty($user_id)){
				throw new Exception("用户id不能为空");
			}
			$sql="DELETE FROM `article` WHERE `article_id`=:article_id AND `user_id`=:user_id";
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':article_id',$article_id,PDO::PARAM_INT);
			$stmt->bindParam(':user_id',$user_id,PDO::PARAM_INT);
			$stmt->execute();
			$resId= $stmt->rowCount();
			if(empty($resId)){
				throw new Exception("删除失败");
			}
			return $resId;

		}

		//查询所有
		public function listForPage($user_id,$page=1,$pagesize=2){
			if(empty($user_id)){
				throw new Exception("用户id不能为空");
			}

			$total=($page-1)*$pagesize;
			$sql="SELECT * FROM `article` WHERE `user_id`=:user_id limit :total , :pagesize ";
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':user_id',$user_id,PDO::PARAM_INT);
			$stmt->bindParam(':total',$total,PDO::PARAM_INT);
			$stmt->bindParam(':pageSize',$pagesize,PDO::PARAM_INT);
			$stmt->execute();
			$article = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if(empty($article)){
				throw new Exception("获取文章失败");
			}
			return $article;
		}

		//查询一条
		public function fetOne($article_id){
			if(empty($article_id)){
				throw new Exception("文章id不能为空");
			}
			$sql ="SELECT * FROM `article` WHERE `article_id`=:article_id";
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':article_id',$article_id,PDO::PARAM_INT);
			$stmt->execute();
			$article = $stmt->fetch(PDO::FETCH_ASSOC);
			if(empty($article)){
				throw new Exception("文章不存在",204);
			}
			return $article;
		}


	}
