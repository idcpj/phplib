<?php

	namespace src\Phplib;
	/**
	 * Class Umeng
	 * @package src\Phplib
	 */
	class Umeng{
		protected $appkey = NULL;
		protected $appMasterSecret = NULL;
		protected $timestamp = NULL;
		protected $validation_token = NULL;
		private $_production_mode = true; // true/false 正式/测试模式

		/**
		 * Umeng constructor.
		 * @param string $key
		 * @param string $secret
		 * @param string $path 引入文件所在路径
		 */
		function __construct($key = '', $secret = '', $path = ''){
			require_once $path;
			$this->appkey = $key;
			$this->appMasterSecret = $secret;
			$this->timestamp = strval(time());
		}

		/**
		 * 安卓列表  device_token可以是单个也可以是 ","分隔的多个
		 * @param array $data
		 *                      必传字段   device_token  , title , content ,
		 *                      非必须字段  extra
		 */
		function sendAndroidList($data = []){
			try{
				$Listcast = new AndroidListcast();
				$Listcast->setAppMasterSecret($this->appMasterSecret);
				$Listcast->setPredefinedKeyValue("appkey", $this->appkey);
				$Listcast->setPredefinedKeyValue("timestamp", $this->timestamp);
				$Listcast->setPredefinedKeyValue("play_vibrate", "true");
				$Listcast->setPredefinedKeyValue("play_sound", "true");
				$Listcast->setPredefinedKeyValue("play_lights", "true");
				$Listcast->setPredefinedKeyValue("production_mode", $this->_production_mode);

				$Listcast->setPredefinedKeyValue("display_type", 'notification');//通知


				/**
				 *  "go_app": 打开应用
				 *   "go_url": 跳转到URL
				 *   "go_activity": 打开特定的activity
				 *   "go_custom": 用户自定义内容。
				 */
				$Listcast->setPredefinedKeyValue("after_open", "go_custom"); //自定义行为

				$Listcast->setPredefinedKeyValue("device_tokens", $data['device_token']);
				$Listcast->setPredefinedKeyValue("title", $data['title']);
				$Listcast->setPredefinedKeyValue("ticker", $data['ticker'] ? $data['ticker'] : $data['title']);
				$Listcast->setPredefinedKeyValue("text", $data['content']);
				$Listcast->setPredefinedKeyValue("custom", "暂无");

				if( ! empty($data['extra']) || is_array($data['extra'])){
					foreach($data['extra'] as $k => $v){

						// 例子:$Listcast->setExtraField("action", $data['action']);
						$Listcast->setExtraField($k, $v);
					}
				}
				$Listcast->send();

			} catch(\Exception $e){
				print_r("安卓app推送出错: " . $e->getMessage());
			}
		}

		/**
		 * 单个发送 可以发送通知数量
		 * @param array $data
		 */
		function sendIOSUnicast($data=[]){
			try{
				$unicast = new IOSUnicast();
				$unicast->setAppMasterSecret($this->appMasterSecret);
				$unicast->setPredefinedKeyValue("appkey", $this->appkey);
				$unicast->setPredefinedKeyValue("timestamp", $this->timestamp);

				$unicast->setPredefinedKeyValue("device_tokens", $data['device_token']);
				$unicast->setPredefinedKeyValue("alert", $data['title']);
				$unicast->setPredefinedKeyValue("sound", "chime");
				$unicast->setPredefinedKeyValue("content-available", $data['content']);

				//扩展消息
				if( ! empty($data['extra']) || is_array($data['extra'])){
					foreach($data['extra'] as $k => $v){

						// 例子:	 $unicast->setCustomizedField("title", $msg['title']); //标题
						$unicast->setCustomizedField($k, $v);
					}
				}

				//获取角标值
				if(!empty($data['badge'])){
					$unicast->setPredefinedKeyValue("badge", $data['badge']);//获取角标值
				}

				$unicast->setPredefinedKeyValue("production_mode", $this->_production_mode);

				$unicast->send();

			} catch(\Exception $e){
				print_r("IOSAPp推送发送失败: " . $e->getMessage());
			}

		}

		/**
		 * 多个token发送
		 * @param array  $data
		 */
		function sendIOSList($data=[]){
			try{
				$Listcast = new IOSListcast();
				$Listcast->setAppMasterSecret($this->appMasterSecret);
				$Listcast->setPredefinedKeyValue("appkey", $this->appkey);
				$Listcast->setPredefinedKeyValue("timestamp", $this->timestamp);


				// Set your device tokens here
				$Listcast->setPredefinedKeyValue("device_tokens", $data['device_token']);
				$Listcast->setPredefinedKeyValue("alert", $data['title']);
				$Listcast->setPredefinedKeyValue("sound", "chime");
				$Listcast->setPredefinedKeyValue("content-available", $data['content']);

				//扩展消息
				if( ! empty($data['extra']) && is_array($data['extra'])){
					foreach($data['extra'] as $k => $v){

						// 例子:	 $unicast->setCustomizedField("title", $msg['title']); //标题
						$Listcast->setCustomizedField($k, $v);
					}
				}

				$Listcast->setPredefinedKeyValue("production_mode", $this->_production_mode);

				$Listcast->send();
			} catch(Exception $e){
				print_r("IOS列播推送出错:".$e->getMessage());
			}
		}

	}
