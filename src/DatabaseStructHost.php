<?php declare(strict_types=1);
namespace Pazer\DatabaseManager;
class DatabaseStructHost {
    protected array $_data;
    public function __construct() { return $this->clear(); }
    public function clear() : self { $this->_data = array("hostname" => "", "username" => "", "password" => "", "database" => "", "port" => "", "charset" => ""); return $this; }
    public function setHostInfo(string $hostname, string $username, string $password, string $database, int $port = 3306, string $charset = "utf8mb4") : self { $this->_data['hostname'] = $hostname; $this->_data['username'] = $username; $this->_data['password'] = $password; $this->_data['database'] = $database; $this->_data['port'] = $port; $this->_data['charset'] = $charset; return $this; }
    public function hostname() : string { return $this->_data[__FUNCTION__] ?? ""; }
    public function username() : string { return $this->_data[__FUNCTION__] ?? ""; }
    public function password() : string { return $this->_data[__FUNCTION__] ?? ""; }
    public function database() : string { return $this->_data[__FUNCTION__] ?? ""; }
    public function charset() : string { return $this->_data[__FUNCTION__] ?? ""; }
    public function port() : int { return $this->_data[__FUNCTION__] ?? 3306; }
}
