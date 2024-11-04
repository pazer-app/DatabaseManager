<?php declare(strict_types=1);
namespace PazerApp\DatabaseManager;
class DatabaseStructFrom {
    protected array $_data;
    public function __construct() { return $this->clear(); }
    public function clear() : self { $this->_data = array("execute" => false, "code" => 0); return $this; }
    public function toArray() : array { return $this->_data; }
    public function toJSON() : string { return json_encode($this->toArray(), 256); }
    protected function _getFuncName(string $name) : string { return mb_substr($name, 4); }
    protected function _sets(string $name, $value) : self { $this->_data[$this->_getFuncName($name)] = $value; return $this; }
    protected function _gets(string $name) { return $this->_data[$this->_getFuncName($name)]; }
    public function set_code(int $port) : self { return $this->_sets(__FUNCTION__, $port); }
    public function set_message(string $message) : self { return $this->_sets(__FUNCTION__, $message); }
    public function set_data(array $data) : self { return $this->_sets(__FUNCTION__, $data); }
    public function set_count(int $count) : self { return $this->_sets(__FUNCTION__, $count); }
    public function set_affected_rows(int $affected_rows) : self { return $this->_sets(__FUNCTION__, $affected_rows); }
    public function set_insert_id(int $insert_id) : self { return $this->_sets(__FUNCTION__, $insert_id); }
    public function set_execute(bool $execute) : self { return $this->_sets(__FUNCTION__, $execute); }
    public function get_code() : int { return $this->_gets(__FUNCTION__) ?? 0; }
    public function get_message() : string { return $this->_gets(__FUNCTION__) ?? ""; }
    public function get_data() : array { return $this->_gets(__FUNCTION__) ?? array(); }
    public function get_count() : int { return $this->_gets(__FUNCTION__) ?? 0; }
    public function get_affected_rows() : int { return $this->_gets(__FUNCTION__) ?? 0; }
    public function get_insert_id() : int { return $this->_gets(__FUNCTION__) ?? 0; }
    public function get_execute() : bool { return $this->_gets(__FUNCTION__) ?? false; }
}
