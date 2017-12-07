<?php

	namespace Phplib;

	use Exception;
	use OSS\OssClient;

	class Alioss{

		private $keyId;
		private $keySecret;
		private $endPoint;
		private $bucket;
		private $oss;

		public function __construct($config){
			$this->keyId =$config['keyId'];     //阿里云oss key_id
			$this->keySecret =$config['keySecret'];     //阿里云oss key_secret
			$this->endPoint =$config['endPoint'];       // 阿里云oss endpoint
			$this->bucket =$config['bucket'];       // bucken 名称
			$this->oss=new OssClient($this->keyId,$this->keySecret,$this->endPoint);

		}

		/**
		 * 上传文件
		 * @param         $path
		 * @param bool    $isDel 是否删除源文件
		 * @return bool
		 * @throws Exception
		 * @internal param bool|是否 $isOutOssPath 是否
		 * @internal param $outOssPath
		 */
		public function ossUpload($path,$isDel=false){
			// 先统一去除左侧的.或者/ 再添加./
			$ossPath = ltrim($path, './');

			if (file_exists($path)) {
				// 上传到oss
				$this->oss->uploadFile($this->bucket,$ossPath,$path);

				// 如需上传到oss后 自动删除本地的文件 则删除下面的注释
				if($isDel){
					unlink($path);
				}

				return true;
			}
			throw new Exception("路径不存在",10002);
		}


		/**
		 * 获取完整网络连接
		 * @param  string $path 文件路径
		 * @return string http连接
		 * @throws Exception
		 */
		function getUrl($path){
			// 如果是空；返回空
			if (empty($path)) {
				throw new Exception("路径为空",10002);
			}
			// 如果已经有http直接返回
			if (strpos($path, 'http://')!==false) {
				return $path;
			}
			// 获取bucket
			return 'http://'.$this->bucket.'.oss-cn-beijing.aliyuncs.com'.$path;
		}

		/**
		 * 删除oss上指定文件
		 * @param  string $object 文件路径 例如删除 /Public/README.md文件  传Public/README.md 即可
		 */
		function ossDeletObject($object){
			// 获取bucket名称
			$test=$this->oss->deleteObject($this->bucket,$object);
		}

		
	}