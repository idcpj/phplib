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

