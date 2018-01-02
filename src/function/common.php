<?php

	//中文不转义
	function encode($arr)
	{
		array_walk_recursive($arr, function(&$item, $key){
			if(is_string($item)) $item = mb_encode_numericentity($item, array(0x80, 0xffff, 0, 0xffff,), 'UTF-8');
		});

		return mb_decode_numericentity( json_encode($arr), array( 0x80, 0xffff, 0, 0xffff,), 'UTF-8');
	}

	//创建文件夹
	function create_dir($dirName, $recursive = 1,$mode=0777) {
		! is_dir ( $dirName ) && mkdir ( $dirName,$mode,$recursive );
	}

	//多位数组进行排序

	/**
	 * 二维数组根据某个字段排序
	 * @param array $array 要排序的数组
	 * @param string $keys   要排序的键字段
	 * @param string $sort  排序类型  SORT_ASC     SORT_DESC
	 * @return array 排序后的数组
	 */
	function arraySort($array, $keys, $sort = 'SORT_DESC') {
		$keysValue = [];
		foreach ($array as $k => $v) {
			$keysValue[$k] = $v[$keys];
		}
		array_multisort($keysValue, $sort, $array);
		return $array;
	}


