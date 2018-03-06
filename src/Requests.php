<?php
/**
 * 
 * @fileName Requests.php
 * @category PHP
 * @package void
 * @author Kee Guo <chinboy2012@gmail.com> 
 * @since 05/03/2018
 * @version Requests.php 2018.03.05
 * */
namespace Eees\Requests;

class Requests {

  static protected $_instance = null;

  protected $_server, $_data, $_get, $_post, $_raw;

  protected function __construct () {
    $this->_server = Server::getInstance();
    $this->_getRequests();
  }

  static public function getInstance () {
    if (null === self::$_instance) self::$_instance = new self;
    return self::$_instance;
  }

  protected function _getRequests () {
    $this->_get = $_GET;
    $this->_post = $_POST;
    $this->_data = $this->_get + $this->_post;

    // parse RAW data
    $this->_getRaw();
    if ( is_array($this->_raw) ) $this->_data += $this->_raw;
    return $this;
  }

  protected function _getRaw () {
    $raw = file_get_contents('php://input');
    $contentType = trim( strtolower($this->_server->content_type) );
    switch($contentType) {
      case 'application/json':
        $this->_raw = json_decode($raw, true);
        break;
      case 'application/xml':
        $this->_raw = $this->_parseXML($raw);
        break;
      case 'text/xml':
        $this->_raw = $this->_parseXML($raw);
        break;
      default:
        $this->_raw = $raw;
        break;
    }
    return $this;
  }

  protected function _parseXML ($raw) {
    return json_decode( json_encode( simplexml_load_string($raw) ) , true);
  }

  public function all () {
    return $this->_data;
  }

  public function url () {
    $url = $this->fullurl();
    return current( explode('?', $this->fullurl()) );
  }

  public function fullurl () {
    return $this->_server->request_uri;
  }

  public function query () {
    return http_build_query($this->_get);
  }

  public function method () {
    return $this->_server->request_method;
  }

  public function is ($method) {
    return strtoupper($method) == strtoupper($this->method());
  }

  /**
   * @param string|array      $keys  
   * */
  public function has ($keys) {
    if (!is_array($keys)) {
      return false !== $this->_fetch($keys, $this->_data);
    }

    foreach ($keys as $key) {
      if (false === $this->_fetch($key, $this->_data)) {
        return false;
      }
    }
    return true;
  }

  public function input ($name) {
    return $this->_fetch($name, $this->_data)['value'];
  }

  protected function _fetch ($keys, $data) {
    $keys = explode('.', $keys);
    if (!$keys) return false;
    if (count($keys) == 1) {
      if (isset($data[$keys[0]])) return array('key' => $keys[0], 'value' => $data[$keys[0]]);
      return false;
    }
    foreach ($keys as $key) {
      if (isset($data[$key])) {
        array_shift($keys);
        $data = $data[$key];
        if (count($keys) > 0) 
          return $this->_fetch(implode('.', $keys), $data);
        else return false;
      }
    }
    return false;
  }

  public function only (array $keys) {
    $data = array();
    foreach ($keys as $key) {
      $fetch = $this->_fetch($key, $this->_data);
      if (false !== $fetch) {
        $data[$fetch['key']] = $fetch['value'];
      }
    }
    return $data;
  }

  public function except (array $keys) {
    $data = $this->_data;
    foreach ($keys as $key) {
      if (isset($data[$key])) unset($data[$key]);
    }
    return $data;
  }

}
