<?php

	namespace Phplib;

	class File{

		/**
		 * 下载本地 及网  络资源文件
		 * @param $filePath
		 * @param $outName
		 * @internal param $orderData
		 * @internal param $orderid
		 * @return bool
		 */
		public static function downloadFile($filePath, $outName=''){
			ob_clean();

			$ext = pathinfo($filePath,PATHINFO_EXTENSION);

			if(empty($outName)){
				$outName = pathinfo($filePath,PATHINFO_FILENAME);
			}

			$file = file_get_contents($filePath);

			if(empty($file)){
				return false;
			}
			header("Content-type: application/octet-stream");
			header("Accept-Ranges: bytes");
			header("Accept-Length: " . strlen($file));
			header('Content-Disposition: attachment; filename=' . $outName.'.'.$ext);
			header("Pragma:no-cache");
			header("Expires:0");
			echo $file;
			die;

		}

		/**
		 * 创建压缩文件
		 * @param      $dataArr      要打包的数据
		 * @param      $fileName     创建要压缩的文件名路径
		 * @param bool $type 为TRUE  生成后立即下啊
		 * @return string
		 */
		public static function createZip($dataArr, $fileName, $type = true){
			//图片数组
			if( ! is_array($dataArr)) return "参数有误";
			//创建压缩包的路径
			if(empty($fileName)) return "请填写保存路径";
			$zip = new \ZipArchive;
			$zip->open($fileName, \ZipArchive::OVERWRITE);
			//往压缩包内添加目录
			foreach($dataArr as $key => $value){
				$fileData = file_get_contents($value);
				if($fileData){
					//zip中文件路径
					$zipDir = '';
					$zip->addFromString($zipDir . basename($value), $fileData);
				}
			}
			$zip->close();
			//下载文件
			if($type){
				self::downloadFile($fileName);
			}
		}

		/**
		 *ftp 用php上传文件到服务器
		 * @param                $csv_filename     时间戳命名的txt文件
		 * @param string $content txt文件内容
		 * @param array          $config
		 * @return bool
		 * @throws \Exception
		 */
		public static function  ftp($csv_filename, $content='',$config=[]){

			if( empty($config)|| !is_array($config)){
				throw new \Exception("config 参数为空",'1001');
			}
			$strServer = $config['host']; //ip
			$strServerPort = $config['post'];//端口
			$strServerUsername = $config['username'];//用户名
			$strServerPassword = $config['password'];//密码

			$resConnection = ssh2_connect($strServer, $strServerPort);

			if(ssh2_auth_password($resConnection, $strServerUsername, $strServerPassword)){
				$resSFTP = ssh2_sftp($resConnection);
				$resFile = fopen("ssh2.sftp://{$resSFTP}/" . $csv_filename, 'w');         //获取句柄
				fwrite($resFile, $content);  //写入内容
				fclose($resFile);   //关闭句柄

				return true;
			}
			else{
				return false;
			}
		}

		/**
		 * ftp上传
		 * @param        $fileName
		 * @param string $content
		 * @param string $path
		 * @param array  $config
		 * @throws \Exception
		 */
		public static function sftp($fileName, $content = '', $path = '', $config = []){
			// 连接FTP
			$host = $config['host']; //ip
			$port = $config['port']; //ip
			$username = $config['username'];//用户名
			$password = $config['password'];//密码
			if(empty($config) || ! is_array($config)){
				throw new \Exception("config 参数为空", '1001');
			}
			if(is_dir($path)){
				throw new \Exception('path不是目录', '10001');
			}
			//先在本地生成文件
			$file = $path . $fileName;
			$fp = fopen($file, 'w');
			fwrite($fp, $content);
			fclose($fp);

			$fp = fopen($file, 'r');
			$conn_id = ftp_connect($host, $port);
			ftp_login($conn_id, $username, $password);
			ftp_pasv($conn_id, TRUE);
			// 上传
			if(ftp_fput($conn_id, $fileName, $fp, FTP_ASCII)){
				//echo "Successfully uploaded $file\n";
			} else{
				throw new \Exception('上传文件失败', '10001');
				//echo "There was a problem while uploading $file\n";
			}
			// 退出
			ftp_close($conn_id);
			fclose($fp);
			unlink($file);//删除生成的临时文件
		}


	}



