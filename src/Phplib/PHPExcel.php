<?php

	namespace Phplib;
	use Exception;
	use PHPExcel_Cell;
	use PHPExcel_IOFactory;

	class   PHPExcel{

		/**
		 * 此方法无需考虑有多少列字段和多少行数据,可自动判断
		 * 导出为 xlsx 文件
		 * @param string $xlsName           文件名
		 * @param array  $expCellName       单元格对应字段名
		 * @param array  $expTableData      三维数据
		 * @param string $exTitle excel     表中 第一行标题
		 * @throws Exception
		 */
		public static function exportExcel($xlsName = '', $expCellName = array(), $expTableData = array(), $exTitle = ''){
			date_default_timezone_set('PRC');
			if(empty($xlsName)){
				throw new Exception('文件名不能为空');
			}
			$fileName = iconv('utf-8', 'gb2312', $xlsName);//文件名称
			if(empty($fileName)){
				throw new \Exception('fileName为空');
			}
			$cellNum = count($expCellName);
			$dataNum = count($expTableData);
			/*如果是tp3.2 用此方法引入*/
			// vendor("PHPExcel.PHPExcel");
			$objPHPExcel = new \PHPExcel();
			if(empty($objPHPExcel)){
				throw new \Exception('没有加载PHPexcel 类');
			}
			$cellName = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ',);

			if(empty($xlsName)){
				$objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[ $cellNum - 1 ] . '1');//合并单元格
			} else{
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $exTitle);
			}
			for($i = 0; $i < $cellNum; $i++){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[ $i ] . '2', $expCellName[ $i ][1]);
			}
			// Miscellaneous glyphs, UTF-8
			for($i = 0; $i < $dataNum; $i++){
				for($j = 0; $j < $cellNum; $j++){
					$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[ $j ] . ($i + 3), $expTableData[ $i ][ $expCellName[ $j ][0] ]);
				}
			}
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
			header("Content-Type:application/force-download");
			header("Content-Type:application/vnd.ms-execl");
			header("Content-Type:application/octet-stream");
			header("Content-Type:application/download");;
			header('Content-Disposition: attachment;filename="' . $fileName . '.xls"'); //phpfensi.com
			header("Content-Transfer-Encoding:binary");
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			exit;
		}

		/**
		 * 把xml解析成数据
		 * @param      $file        文件路径
		 * @param bool $NotEmty     是否自动删除空白行
		 * @return array
		 */
		public static function excelConvertData($file,$NotEmty=false){
			// 判断文件是什么格式
			$type = pathinfo($file);
			$type = strtolower($type["extension"]);
			$type=$type==='csv' ? $type : 'Excel5';
			ini_set('max_execution_time', '0');

			// 判断使用哪种格式
			$objReader = PHPExcel_IOFactory::createReader($type);
			$objPHPExcel = $objReader->load($file);
			$sheet = $objPHPExcel->getSheet(0);
			// 取得总行数
			$highestRow = $sheet->getHighestRow();
			// 取得总列数
			$highestColumn = $sheet->getHighestDataColumn();

			//循环读取excel文件,读取一条,插入一条
			$data=array();
			//从第一行开始读取数据
			for($j=1;$j<=$highestRow;$j++){
				//从A列读取数据
				for($k='A';$k<=$highestColumn;$k++){
					// 读取单元格
					$colData  =$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
					//过滤为空
					if($NotEmty && empty($colData)){
						continue;
					}
					$data[$j][]=$colData;
				}
			}
			return $data;
		}
	

		

	}
