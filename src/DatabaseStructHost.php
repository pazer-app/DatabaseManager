<?php declare(strict_types=1);
namespace PazerApp\DatabaseManager;
class DatabaseStructHost {
    protected array $_data;
    public function __construct() { return $this->clear(); }
    public function clear() : self { $this->_data = array("hostname" => "", "username" => "", "password" => "", "database" => "", "port" => 3306, "charset" => "utf8mb4"); return $this; }
    public function toArray() : array { return $this->_data; }
    public function toJSON() : string { return json_encode($this->toArray(), 256); }
    protected function _getFuncName(string $name) : string { return mb_substr($name, 4); }
    protected function _sets(string $name, $value) : self { $this->_data[$this->_getFuncName($name)] = $value; return $this; }
    protected function _gets(string $name) { return $this->_data[$this->_getFuncName($name)]; }
    public function set_hostname(string $hostname) : self { return $this->_sets(__FUNCTION__, $hostname); }
    public function set_username(string $username) : self { return $this->_sets(__FUNCTION__, $username); }
    public function set_password(string $password) : self { return $this->_sets(__FUNCTION__, $password); }
    public function set_database(string $database) : self { return $this->_sets(__FUNCTION__, $database); }
    public function set_port(int $port) : self { return $this->_sets(__FUNCTION__, $port); }
    public function set_charset(string $charset) : self { return $this->_sets(__FUNCTION__, $charset); }
    public function get_hostname() : string { return $this->_gets(__FUNCTION__); }
    public function get_username() : string { return $this->_gets(__FUNCTION__); }
    public function get_password() : string { return $this->_gets(__FUNCTION__); }
    public function get_database() : string { return $this->_gets(__FUNCTION__); }
    public function get_port() : int { return $this->_gets(__FUNCTION__); }
    public function get_charset() : string { return $this->_gets(__FUNCTION__); }
    public function client() : DatabaseClient { $client = new DatabaseClient(); $client->set_host($this); return $client; }
}
