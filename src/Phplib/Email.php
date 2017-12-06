<?php
	namespace Phplib;

	use Exception;
	use PHPMailer\PHPMailer\PHPMailer;

	class Email {

		private $email_smtp; //smtp
		private $email_username;  // 账号
		private $email_password;  //密码  注意: 163和QQ邮箱是授权码；不是登录的密码
		private $email_from_name;    //发件人
		private $email_smtp_secure;  // 链接方式 如果使用QQ邮箱；需要把此项改为  ssl
		private $email_port;  // 端口 网易25 如果使用QQ邮箱；需要把此项改为  465
		private $phpmailer;

		/**
		 * 配置email参数
		 * @param array $config
		 * @throws Exception
		 */
		public function __construct($config=[]){
			$this->email_smtp=$config['smtp'];
			$this->email_username=$config['username'];
			$this->email_password=$config['password'];
			$this->email_from_name=$config['from_name'];
			$this->email_smtp_secure=$config['smtp_secure'];
			$this->email_port=$config['port'];

			if(empty($this->email_smtp) || empty($this->email_username) || empty($this->email_password) || empty($this->email_from_name)){
				throw new Exception('邮箱配置不完整',10001);
			}

			$this->phpmailer=new PHPMailer();
			// 设置PHPMailer使用SMTP服务器发送Email
			$this->phpmailer->IsSMTP();
			// 设置设置smtp_secure
			$this->phpmailer->SMTPSecure=$this->email_smtp_secure;
			// 设置port
			$this->phpmailer->Port=$this->email_port;
			// 设置为html格式
			$this->phpmailer->IsHTML(true);
			// 设置邮件的字符编码'
			$this->phpmailer->CharSet='UTF-8';
			// 设置SMTP服务器。
			$this->phpmailer->Host=$this->email_smtp;
			// 设置为"需要验证"
			$this->phpmailer->SMTPAuth=true;
			// 设置用户名
			$this->phpmailer->Username=$this->email_username;
			// 设置密码
			$this->phpmailer->Password=$this->email_password;
			// 设置邮件头的From字段。
			$this->phpmailer->From=$this->email_username;
			// 设置发件人名字
			$this->phpmailer->FromName=$this->email_from_name;

		}

		/**
		 * 添加附件
		 * @param $path  附件文件地址
		 * @return $this
		 */
		public function addAttach($path){
			$this->phpmailer->addAttachment($path);
			return $this;
		}

		/**
		 * 发送Email
		 * @param string|array  $address    邮箱可发送多人
		 * @param string $subject           标题
		 * @param string $content           内容
		 * @return bool
		 * @throws Exception
		 */
		public  function sendEmail($address='',$subject='',$content=''){

			// 可添加多个
			if(is_array($address)){
				foreach($address as $addressv){
					$this->phpmailer->AddAddress($addressv);
				}
			}else{
				$this->phpmailer->AddAddress($address);
			}
			// 设置邮件标题
			$this->phpmailer->Subject=$subject;
			// 设置邮件正文
			$this->phpmailer->Body=$content;

			// 发送邮件。
			if(!$this->phpmailer->Send()) {
				throw new Exception($this->phpmailer->ErrorInfo,10002);
			}
			return true;
		}
	}

