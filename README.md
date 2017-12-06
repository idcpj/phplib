## 安装
为了方便自己开发新项目,收集项目中常用功能进行封装并用Composer进行下载

`composer require phpcpj/phplib dev-master` 

## 文件目录介绍


### src - 类库存放文件

**Curl.php**
---

1.用`curl`方法进行双向认证的类


**File.php**
---

`downloadFile`方法  下载本地或网络资源

`createZip`方法     压缩文件

`ftp`方法           用php上传文件到ftp服务器

`sftp`方法         用php上传文件到stp服务器


**Umeng.php**
---

`sendAndroidList`方法  安卓列播放

`sendIOSUnicast`方法    Ios单播

`sendIOSList`方法         Ios列表

**PHPExcel.php**
---

`exportExcel` 方法        数组转excel  并下载 

`excelConvertData` 方法    解析excel 第二个参数设置删除空白行数据


**Pdf.php**
---

采用链式调用

中文文件名无法识别的问题
```php
1、注释以下代码，大约在7565-7568行：

if ($dest[0] != 'F') {
	$name = preg_replace('/[\s]+/', '_', $name);
	$name = preg_replace('/[^a-zA-Z0-9_\.-]/', '', $name);
}

2、搜索该方法代码，替换如下代码，大约分别在7639、7670、7693、7718行。
	header('Content-Disposition: attachment; filename="'.basename($name).'"');
	替换为
	header('Content-Disposition: attachment; filename="'.$name.'"');

```

`setHeader`   设置页眉

`htmlToPdf`   设置html转pdf

`addImg`      添加图片

`showPdf` | `downPdf`  | `savePdf`  展示 |下载| 保存到服务器 


**Email.php**
---


`__construct`  初始化配置

`addAttach`    添加附件地址

`sendEmail`    发送文件


### test
测试类库文件,分别对应src中的类库

### doc 
php 基础知识

### html
前端知识存放处

## wiki
php 环境配置等请前往wiki
