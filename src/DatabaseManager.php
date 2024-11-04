<?php declare(strict_types=1);
namespace PazerApp\DatabaseManager;
class DatabaseManager {
    protected array $_data;
    public function __construct() { return $this->clear(); }
    public function clear() : self { $this->_data = array(); return $this; }
    public function host(string $name) : DatabaseStructHost { if(!isset($this->_data[$name])){ $this->_data[$name] = new DatabaseStructHost(); } return $this->_data[$name]; }
    public function client(string $name) : DatabaseClient { $client = new DatabaseClient(); $client->set_host($this->host($name)); return $client; }
}
