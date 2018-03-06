<?php
/**
 * 
 * @fileName Server.php
 * @category PHP
 * @package void
 * @author Kee Guo <chinboy2012@gmail.com> 
 * @since 05/03/2018
 * @version Server.php 2018.03.05
 * */
namespace Eees\Requests;

class Server {

  protected static $_instance = null;

  protected $_server = array();

  protected $_header = array();

  /**
   * initialized server parameters
   * */
  protected function __construct () {
    $this->_server = $_SERVER;
    $this->_fetchServers();
  }

  protected function _fetchServers () {
    foreach ($this->_server as $key => $val) {
      if (preg_match('/^HTTP_/s', $key)) {
        $key = preg_replace('/^HTTP_/si', '', $key);
        $this->_setHeader($key, $val);
        $this->_server['HEADER'][$key] = $val;
      }
    }
    return $this;
  }

  protected function _setHeader ($name, $value) {
    return $this->_header[$name] = $value;
  }

  static public function getInstance () {
    if (null === self::$_instance) self::$_instance = new self;
    return self::$_instance;
  }

  static public function __callStatic ($name, $args) {
    $self = Server::getInstance();
    if (!method_exists($self, $name)) {
      return false;
    }
    return call_user_func_array( array( $self, $name ) , $args );
  }

  public function all() {
    return $this->_server;
  }

  public function header ($name = NULL) {
    if (null === $name) return $this->_header;
    $name = $this->_converKey($name);
    if (isset($this->_header[$name])) return $this->_header[$name];
    return NULL;
  }

  public function __get ($name) {
    $name = $this->_converKey($name);
    if ( !array_key_exists($name, $this->_server) ) {
      return NULL;
    }
    return $this->_server[$name];
  }

  protected function _converKey ($key) {
    return strtoupper( str_replace('-', '_', $key) );
  }
}
