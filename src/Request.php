<?php
/**
 * 
 * @fileName Request.php
 * @category PHP
 * @package void
 * @author Kee Guo <chinboy2012@gmail.com> 
 * @since 05/03/2018
 * @version Request.php 2018.03.05
 * */
namespace Eees\Requests;

use Closure;
use ArrayAccess;
use RuntimeException;

class Request implements ArrayAccess {

  static protected $_methodPoint = array(
    'request'     => 'Requests::getInstance',
    'server'      => 'Server::getInstance',
    'files'       => 'Files@getInstance',
    'header'      => 'Server@header',
    'all'         => 'Requests@all',
    'fullurl'     => 'Requests@fullurl',
    'url'         => 'Requests@url',
    'method'      => 'Requests@method',
    'is'          => 'Requests@is',

    // request parameters
    'get'        => 'Requests@get',
    'post'       => 'Requests@post',
    'input'      => 'Requests@input',
    'has'        => 'Requests@has',
    'only'       => 'Requests@only',
    'except'     => 'Requests@except',
    'filter'     => 'Filters@filter',

    // files
  );

  public static function __callStatic ($name, $args) {
    if (!array_key_exists($name, self::$_methodPoint))
      return false;

    $callAction = self::$_methodPoint[$name];
    if (false !== strpos($callAction, '@')) {
      list($class, $method) = explode('@', $callAction);
    }
    elseif (strpos($callAction, '::')) {
      list($class, $method) = explode('::', $callAction);
    }
    else return false;
    $class = '\\Eees\\Requests\\' . $class;

    if (!class_exists($class)) {
      throw new RuntimeException('class ' . $class . ' not foud!');
    }

    $callback = array(
      $class::getInstance(), $method
    );
    return call_user_func_array($callback, $args);
  }

  public function offsetExists ($name) {
    
  }

  public function offsetGet ($name) {
  
  }

  public function offsetSet ($name, $value) {
    
  }

  public function offsetUnset ($name) {
  
  }

  static public function version () {
    return 'Eees\Requests version 0.1';
  }
}
