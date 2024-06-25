<?php declare(strict_types=1);
namespace PazerApp\DatabaseManager;
use mysqli;
use mysqli_result;
class DatabaseClient {
    protected bool $state = false;
    protected DatabaseStructHost $_host;
    protected ?mysqli $_client;
    public function __construct(DatabaseStructHost $hostInfo = null) { $this->_client = null; $this->clear(); if($hostInfo !== null) $this->_host = $hostInfo; return $this; }
    public function clear() : self { $this->close(); $this->_host = new DatabaseStructHost(); return $this; }
    public function connect() : self { $this->state = false; $this->_client = @new mysqli($this->_host->hostname(), $this->_host->username(), $this->_host->password(), $this->_host->database(), $this->_host->port()); if(!$this->_client->connect_error) { $this->state = true; $this->_client->set_charset($this->_host->charset()); } return $this; }
    public function close() : self { if ($this->_client instanceof mysqli) { @$this->_client->close(); } $this->_client = null; $this->state = false; return $this; }
    public function state() : bool { return $this->state; }
    public function core() : ?mysqli { return $this->_client ?? null; }
    public function query(string $query, array $values) : ?mysqli_result {
        $stmt = $this->_client->stmt_init();
        $stmt->prepare($query);
        if(sizeof($values) > 0) $stmt->bind_param($this->getStmtTypes($values),...$values);
        $stmt->execute();
        $data = $stmt->get_result() ?? null;
        $stmt->close();
        return $data ?? null;
    }
    public function getStmtTypes(array $values) : string {
        $types = "";
        foreach ($values as $value) {
            if(is_int($value)) $types.="i";
            else if(is_float($value)) $types.="d";
            else if(is_bool($value)) $types.="b";
            else $types.="s";
        }
        return $types;
    }
}
