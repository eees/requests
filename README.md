# Eees/requests

获取请求参数的Request包

Useage:

```
use Eees\Requests\Request;

// 获取Request对象
Request::request();     // return Eees/Requests/Requests

// 获取Server对象
Request::server();      // return Eees/Requests/Server 

// 获取Http 请求头
Request::http('name');  // return array | string

// 获取全部request参数 (GET / POST / RAW)
Request::all();          // return array

// 获取request_uri
Request::fullurl();      // return string (path + query)

// 获取request_uri only path
Request::url()           // return string (only path)

// 获取请求方法
Request::method()        // return string (GET | POST | DELETE | PUT | PATCH ...)

// 判断是否符合请求
Request::is('POST')      // return bool 

// 获取GET 请求参数
Request::get('name')     // return GET param

// 获取POST 请求参数
Request::post('name')    // return POST param

// 获取request 参数
Request::input('name')   // return string | array

// 判断是否存在参数(多个参数判断存在false则返回false)
Request::has('key');                           // return bool
Request::has('key.sub');                       // return bool
Request::has(['key1', 'key2.sub']);            // return bool

// 仅获取列表提供的数据
Request::only(['key1', 'key2.sub', 'key3.sub2.sub3']);    // return array

// 获取除列表提供的数据之外的全部 (except 不提供多维索引)
Request::except(['key1', 'key2', 'key3']);                // return array

// 过滤参数返回 - 未提供
Request::filter('key', 'array|int|string')

```
