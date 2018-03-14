<?php

	namespace Phplib;

	class Md5Rsa{
		//商户公钥
		protected $_pubkey;
		//商户私钥
		protected $_prikey;

		public function __construct($prikey, $pubkey){
			$this->_prikey = $prikey;
			$this->_pubkey = $pubkey;
		}

		private function _Sign($param){
			if( ! is_array($param)){
				echo "并非数组";
			}
			//删除空数组并排序
			ksort($param);
			var_dump(http_build_query($param));
			$paramStr = urldecode(http_build_query($param));
			$signature = $this->_CreateSign($paramStr);
			//验证
			print_r("验证结果:");
			$this->isValid($paramStr,$signature);
			$result = base64_encode($signature);

			return $result;

		}

		/**
		 * 利用约定数据和私钥生成数字签名
		 * @param 待签数据|string $data 待签数据
		 * @return String 返回签名
		 */
		public function _CreateSign($data = ''){
			if(empty($data)){
				return false;
			}
			$private_key = file_get_contents($this->_prikey);
			if(empty($private_key)){
				echo "Private Key error!";
				return false;
			}
			$pkeyid = openssl_get_privatekey($private_key);
			if(empty($pkeyid)){
				echo "private key resource identifier False!";

				return false;
			}
			$verify = openssl_sign($data, $signature, $pkeyid, OPENSSL_ALGO_MD5);
			openssl_free_key($pkeyid);

			return $signature;
		}

		/**
		 * 利用公钥和数字签名以及约定数据验证合法性
		 * @param 待验证数据|string $data      待验证数据
		 * @param 数字签名|string  $signature 数字签名
		 * @return bool|int -1:error验证错误 1:correct验证成功 0:incorrect验证失败
		 */
		public function isValid($data = '', $signature = ''){
			if(empty($data) || empty($signature)){
				return false;
			}
			$public_key = file_get_contents($this->_pubkey);
			if(empty($public_key)){
				echo "Public Key error!";

				return false;
			}
			$pkeyid = openssl_get_publickey($public_key);
			if(empty($pkeyid)){
				echo "public key resource identifier False!" . "<br/>";

				return false;
			}
			$ret = openssl_verify($data, $signature, $pkeyid, OPENSSL_ALGO_MD5);
			switch($ret){
				case -1:
					echo "error";
					break;
				default:
					echo $ret == 1 ? "success" : "incorrect"; //0:incorrect
					break;
			}

			return $ret;
		}

		/**
		 * @param $data
		 * @return mixed
		 */
		public function sendAction($data){
			//原始值在加上sign 进行发送,验证时候,用原始值进行同样的操作进行验证
			if(isset($data['sign'])){
				unset($data['sign']);
			}
			$data['sign'] = $this->_Sign($data);

			return $data;
		}

	}