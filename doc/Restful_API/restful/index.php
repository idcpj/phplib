<?php



	/**
	 *通过htaccess重写后
	 * 	/Resfult_API/restful/artcile
	 * 这个不存在的article会显示在PATH_INFO中
	 * [PATH_INFO] => /article
	 */
	//print_r($_SERVER);


	require __DIR__.'/../lib/User.php';
	require __DIR__.'/../lib/Article.php';

	$pdo = require  __DIR__.'/../lib/db.php';


	class Restful{
		private $_user;
		private $_article;
		//请求方法
		private $_requertMethod;
		//请求的资源名称
		private $_resourceName;
		//请求的资源id
		private $_id;

		//允许请求的资源列表
		private $_allowResources = ['user','article'];
		//允许请求的HTTP方法
		private $_allowRequsetMethods =['GET','POST','PUT','DELETE','OPTIONS'];

		private $_statusCodes=[
			200=>'ok',
		    204=>'No Content',
		    400=>'Bad Request',
		    403=>'Unauthorized',
		    404=>'Not Found',
		    405=>'Method Not found',
		    500=>'Server Internal Error'
		];

		public function __construct(User $user,Article $article){
			$this->_user=$user;
			$this->_article=$article;
		}

		public function run(){
			try{
				$this->_setupRequestMethod();
				$this->_setupResource();
				if($this->_resourceName=='user'){
					$this->_json($this->_handleUser());
				}else{
					$this->_json($this->_handleArticle());
				}
			}catch(Exception $e){
				$this->_json(['error'=>$e->getMessage()],$e->getCode());
			}
		}

		//初始化请求方法
		private function _setupRequestMethod(){
			$this->_requertMethod=$_SERVER['REQUEST_METHOD'];
			if(!in_array($this->_requertMethod,$this->_allowRequsetMethods)){
				throw new Exception("请求方法不被允许",405);
			}
		}

		//初始化请求资源
		//http://localhost/learn/PHP/Restful_API/restful/article/12
		/**
		 * Array
				(
				[0] =>
				[1] => article
				[2] => 12
				)
		 */
		private function _setupResource(){
			$path = $_SERVER['PATH_INFO'];
			$param =explode('/', $path);
			$this->_resourceName=$param[1];
			if(!in_array($this->_resourceName, $this->_allowResources)){
				throw new Exception("请求资源不被允许",400);
			}
			if(!empty($param[2])){
				$this->_id=$param[2];
			}

		}


		//输出json
		private function _json($array,$code=0)
		{
			if($array ===null && $code===0){
				$code=204;
			}
			if($array !==null && $code ===0){
				$code=200;
			}

			header("HTTP/1.1". $code ." ".$this->_statusCodes[$code]);
			header('Content-type:application/json;charset=utf-8');
			echo json_encode($array,JSON_UNESCAPED_UNICODE);
			exit();
		}

		//请求用户资源
		/**
		 * http://localhost/learn/PHP/Restful_API/restful/user
		 * 在raw中输入json
		 * {"username":"123121211","password":"thisispassword"}
		 * 处理请求
		 */
		private function _handleUser()
		{
			if($this->_requertMethod!='POST'){
				throw new Exception("请求方法不被允许",405);
			}
			$body =$this->_getBodyParam();
			if(empty($body['username'])){
				throw new Exception("用户名不能为空",400);
			}
			if(empty($body['password'])){
				throw new Exception("密码不能为空",400);
			}
			$data =$this->_user->register($body['username'], $body['password']);
			return $data;
		}

		//请求文章资源
		private function _handleArticle()
		{
			switch($this->_requertMethod){
				case 'POST':
					return $this->_handleArticleCreate();
				case 'PUT':
					return $this->_handleArticleEidt();
				case 'DELETE':
					return $this->_handleArticleDel();
				case 'GET' :
					if(empty($this->_id)){
						return $this->_handleArticleList();
					}else{
						return $this->_handleArticleView();
					}
				default:
					throw new Exception("请求方式不被允许");
			}

		}

		//获取请求体参数
		private function _getBodyParam()
		{
			/**
			 * php://input可以读取没有处理过的POST数据。
			 * php://input不能用于enctype=multipart/form-data”
			 * 因为是接口.input中的是json
			 * {"username":"12312321","password":"thisispassword"}
			 * 填入
			 */
			$raw = file_get_contents('php://input');
			if(empty($raw)){
				throw new Exception("请求参数错误",400);
			}
			//把json变为数组
			return json_decode($raw,true);
		}

		//创建文章
		private function _handleArticleCreate()
		{
			$body =$this->_getBodyParam();
			if(empty($body['titler'])){
				throw new Exception("文章标题不能为空",400);
			}
			if(empty($body['content'])){
				throw new Exception("文章内容不能为空",400);
			}
			if(empty($body['author'])){
				throw new Exception("文章作者不能为空",400);
			}
			$user = $this->_UserLogin($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);

			try{
				$article = $this->_article->add($body['titler'],$body['content'],$body['author'],$user['user_id']);
				return $article;
			}catch(Exception $e){
				throw new Exception($e->getMessage(),400);
			}
		}
		//编辑文章
		private function _handleArticleEidt()
		{
			try{
				$user=$this->_UserLogin($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
				$article = $this->_article->fetOne($this->_id);
				if($article['user_id'] !=$user['user_id']){
					throw new Exception("没有编辑权限",401);
				}
				$body = $this->_getBodyParam();
				$titler = empty($body)?$article['titler']:$body['titler'];
				$content = empty($body)?$article['content']:$body['content'];


				if($titler ==$article['titler'] && $content==$article['content']){
					return $article;
				}
				return $this->_article->edit($titler, $content, $article['article_id'], $user['user_id']);
			}catch(Exception $e){
				throw new Exception($e->getMessage(),403);
			}

		}

		//文章删除
		private function _handleArticleDel()
		{
			$user=$this->_UserLogin($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
			try{
				$article = $this->_article->fetOne($this->_id);
				if($article['user_id'] !=$user['user_id']){
					throw new Exception("没有编辑权限",401);
				}
				$this->_article->del($this->_id, $user['user_id']);
				return null;

			}catch(EXception $e){
				throw new Exception($e->getMessage(),403);
			}
		}

		private function _handleArticleView()
		{
		}


		private function _UserLogin($username, $password)
		{
			try{
				return $this->_user->login($username, $password);
			}catch(Exception $e){
				throw new Exception($e->getMessage(),400);
			}
		}

		//文章列表
		private function _handleArticleList()
		{
			$user=$this->_user->login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
			$page = isset($_GET['page'])?$_GET['page']:1;
			$pagesize = isset($_GET['pagesize'])?$_GET['pagesize']:10;
			if($pagesize>100){
				throw new Exception("分页太大",400);
			}
			return $this->_article->listForPage($user['user_id'],$page,$pagesize);
		}


	}

	$article=new Article($pdo);
	$user=new User($pdo);
	$restful = new Restful($user, $article);
	$restful->run();