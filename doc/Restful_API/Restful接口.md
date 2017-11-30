#如何设计Restful

## 1.资源路径（URL）
在Restful架构汇中，每个网址代表一种资源，所以网址中不能有动词，只有名词。一般来说API中的名词应该使用附属形式

    例子
    有一个动物园API提供动物园zoo的信息，还包括各种动物和雇员信息，则他的路径应该设计成这样
    https:api.example.com/v1/zoos      v1为版本号
    https:api.example.com/v1/animals   
    https:api.example.com/v1/employees   
    
    
## 2.（HTTP）动词
对资源的操作（CURD），有HTTP动词表示

>GET:从服务器去除资源（一项或多项）

    POST /zoos   新建一个动物园
>POST:在服务器新建一个资源

    GET /zoos/ID   获取某个制定动物园信息
>PUT：在服务器更新资源（客户端提供改变后的完整资源）

    PUT /zoos/ID   更新某个动物园信息
>PATH：在服务器更新资源（客户端提供改变的属性）

>DELETE：从服务器删除资源

    DELETE /zoos/ID   删除某个动物园（需要删除所有动物）


## 3.过滤信息

如果记录数量很多，API应该提供参数，过滤返回结果
    
    ?offset=10      指定返回记录的开始位置
    ?page=2&per_page=100    
    ?sortby=name&order=asc  指定返回结果排序，以及排序顺序
    ?animal_type_id=1       指定筛选条件
## 4.状态码
服务器向用户返回的状态码和提示信息，使用标准HTTP状态码

    200 ok          成功返回用户请求的数据
    201 CREATED     新建或修改数据成功
    204 NO CONTENT  删除数据成功
    ---
    400 BAD REQUEST 用户发出的请求有错误
    401 Unauthorized 用户没有验证，无法进行当前操作
    403 Forbidden   用户访问被禁止
    422 Unprocesable Entity     当创建一个对象时，发生一个验证错误（如密码为空等）
    500 INTERNAL SERVER ERROR   服务器发生错误，用户将无法判定发出的请求是否成功
## 5.错误处理
如果状态码为4xx或5xx，返回错误信息，以error作为键名

    {
        "error":"参数错误"
    }

## 6.返回结果
针对不同操作，服务器向用户返回的结果应该符合一下规范
    
    GET /collections    返回资源对象的列表（数组）
    GET /collections/identity   返回单个资源对象
    POST /collections/identity   返回新生成的资源对象
    PUT /collections/identity   返回完整的资源对象属性
    PATCH /collections/identity   返回被修改的属性
    DELETE /collections/identity   返回204+一个空文档
##编程技巧
1.除index.php外,的其他类库,都使用抛出异常的方式,index.php中在run()接收异常,其他都通过run()调用

2.调用`$_SERVER['PHP_AUTH_USER']```,``` $_SERVER['PHP_AUTH_PW']`

3.`header("HTTP/1.1". $code ." ".$this->_statusCodes[$code]);`
更改状态码 
  
##服务器信息

1.获取发送方法 `$_SERVER['REQUEST_METHOD']`

2.获取`post`信息 ,接收并转换为数组`$post_data = file_get_contents('php://input');` 
  与传统的$_POST不同在于,传统只能通过表单的`methodw='post'`方式才能使用$_POST
  
3.获取路径 `$_SERVER['PATH_INFO']` 
   ```
   http://localhost/learn/PHP/Restful_API/restful/article/12
   通过explode('/', $path)
   获取数据[
        [0] =>
        [1] => article
        [2] => 12
        ]
```

4.传入实例化类

    public function __construct(User $user,Article $article){
        $this->_user=$user;
        $this->_article=$article;
    }
    
    $article=new Article($pdo);
    $user=new User($pdo);
    $restful = new Restful($user, $article);

