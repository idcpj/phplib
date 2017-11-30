#array_map
>对数组中的每个元素进行处理,array_map,只能取值,不能取键名
```php
function arrpus(&$var){
		return $var+2;
	}
	$a=array(1,2,3,4,5);
	return  $b =  array_map('arrpus',$a);
	print_r($b);
```

#array_walk
>对数组中的每个元素进行处理
```php
$a = array(1,2,3,4,5,6,7);
function keypus(&$item,&$key){
    $item = $item+$key;
}
array_walk($a,'keypus');
print_r($a);
```

>每个元素值都加4
```php
$a = array(1,2,3,4,5,6,7);
function numpus(&$item,&$key,$num){
    $item = $item+$num;
}
array_walk($a,'numpus',4);
print_r($a);
```

#array_filter
得到奇数
```php
$a = array(1,2,3,4,5,6,7);
function odd($val){
    if($val%2==1){
        return $val;
    }
}
$b = array_filter($a,'odd');
print_r($b);
```
