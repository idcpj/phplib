<?php

	namespace CHttp;
	class Curl{

		/**
		 * -----BEGIN CERTIFICATE-----
		 */
		protected static $certurl;
		/**
		 * -----BEGIN RSA PRIVATE KEY-----
		 */
		protected static $prikey;
		/**
		 * 密码
		 * @var
		 */
		protected static $keypwd;

		/**
		 * 配置文件路径
		 * @param string $certurl   证书路径
		 * @param string $prikey    私钥路径
		 * @param string $keypwd    私钥密码
		 */
		public function __construct($certurl='', $prikey='', $keypwd=''){
			self::$certurl = $certurl;
			self::$prikey = $prikey;
			self::$keypwd = $keypwd;

		}

		/**
		 * https双向认证
		 * @param $url
		 * @param $data
		 * @return mixed
		 */
		public static function curlPostSsl($url, $data){
			$tuCurl = curl_init();
			curl_setopt($tuCurl, CURLOPT_URL, $url);
			//curl_setopt($tuCurl, CURLOPT_PORT , 443);
			curl_setopt($tuCurl, CURLOPT_VERBOSE, 0);
			curl_setopt($tuCurl, CURLOPT_HEADER, 0);
			curl_setopt($tuCurl, CURLOPT_SSLVERSION, 1);
			curl_setopt($tuCurl, CURLOPT_SSLCERT, self::$certurl);  //-----BEGIN CERTIFICATE-----
			curl_setopt($tuCurl, CURLOPT_SSLCERTTYPE, "PEM");    //
			//curl_setopt($tuCurl,CURLOPT_SSLCERTPASSWD,$this->_keyPwd);      //证书密码
			curl_setopt($tuCurl, CURLOPT_SSLKEY, self::$prikey);       // -----BEGIN RSA PRIVATE KEY-----
			curl_setopt($tuCurl, CURLOPT_SSLKEYPASSWD, self::$keypwd);
			curl_setopt($tuCurl, CURLOPT_SSLKEYTYPE, "PEM");
			//curl_setopt($tuCurl, CURLOPT_CAINFO,$this->_certUrl);//-----BEGIN PUBLIC KEY-----
			curl_setopt($tuCurl, CURLOPT_POST, 1);
			curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, 1);//是否返回数据流
			curl_setopt($tuCurl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($tuCurl, CURLOPT_POSTFIELDS, $data);
			//curl_setopt($tuCurl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml","SOAPAction: \"/soap/action/query\"", "Content-length: ".strlen($data)));
			$tuData = curl_exec($tuCurl);
			if( ! curl_errno($tuCurl)){
				//$info = curl_getinfo($tuCurl);
				//echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'];
			}
			else{
				echo 'Curl 错误: ' . curl_error($tuCurl);
			}
			curl_close($tuCurl);

			return $tuData;
		}
	}


