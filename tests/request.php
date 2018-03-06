<?php
/**
 * 
 * @fileName request.php
 * @category PHP
 * @package void
 * @author Kee Guo <chinboy2012@gmail.com> 
 * @since 05/03/20_8
 * @version request.php 2018.03.05
 * */
$autoload = dirname(__DIR__) . '/vendor/autoload.php';
require_once $autoload;

use Eees\Requests\Request;
use Eees\Requests\Server;

echo "get All requests: <br/> ";
//foreach (Request::all() as $k => $v) {
  //echo "<b style='color: red;'>{$k}</b> => {$v} <br/>";
//}
var_dump(Request::all());
echo "<br/>";

var_dump(Request::has(['hello', 'k']));
echo "<hr/>";

//echo "<pre>" . var_dump(Request::server()) . "</pre>";
var_dump(Request::header('username') . "<br/>");
var_dump(Request::header('content-type') . "<br/>");

echo "get Header: ";
var_dump(Request::header('user_agent'));
echo "<br/>";

echo "get URL: ";
  var_dump(Request::url());
echo "<br/>";

echo "get Method: ";
var_dump(Request::method());
echo "<br/>";

echo "Request is POST: ";
var_dump(Request::is('post'));
echo "<br/>";

echo "Request is GET: ";
var_dump(Request::is('get'));
echo "<br/>";
