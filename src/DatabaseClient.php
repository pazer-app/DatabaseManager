<?php declare(strict_types=1);
namespace PazerApp\DatabaseManager;
use mysqli;
use mysqli_sql_exception;
class DatabaseClient {
    protected DatabaseStructHost $_host;
    protected bool $_status;
    public function __construct() { return $this->clear(); }
    protected function clear() : self { $this->_host = new DatabaseStructHost(); $this->_status = false; return $this; }
    public function set_host(DatabaseStructHost $host) : self { $this->_host = $host; $this->_status = false; return $this; }
    public function get_host() : DatabaseStructHost { return $this->_host; }
    protected function _connect() {
        try {
            $client = new mysqli($this->_host->get_hostname(), $this->_host->get_username(), $this->_host->get_password(), $this->_host->get_database(), $this->_host->get_port());
            if (!$client->connect_error) { $client->set_charset($this->_host->get_charset()); }
            return $client;
        }catch (mysqli_sql_exception $e) {
            return array("code" => $e->getCode(), "message" => $e->getMessage());
        }
    }
    public function read_query(string $query, array $value = array()) : DatabaseStructFrom {
        $form = new DatabaseStructFrom();
        $client = $this->_connect();
        if(is_array($client)) $form->clear()->set_code($client["code"])->set_message($client['message']);
        else{
            try {
                $data = array();
                $stmt = $client->stmt_init();
                $stmt->prepare($query);
                if(sizeof($value) > 0) $stmt->bind_param($this->getStmtTypes($value),...$value);
                $stmt->execute();
                $res = $stmt->get_result();
                while($row = $res->fetch_assoc()) $data[] = $row;
                $form
                    ->clear()
                    ->set_execute(true)
                    ->set_code(200)
                    ->set_count($res->num_rows)
                    ->set_data($data);
                    $stmt->close();
                    $client->close();
            }catch (mysqli_sql_exception $e){
                $form
                    ->clear()
                    ->set_code($e->getCode())
                    ->set_message($e->getMessage());
                    $stmt->close();
                    $client->close();
            }
        }
        return $form;
    }
    public function write_query(string $query, array $value = array()) : DatabaseStructFrom {
        $form = new DatabaseStructFrom();
        $client = $this->_connect();
        if(is_array($client)) $form->clear()->set_code($client["code"])->set_message($client['message']);
        else{
            try {
                $stmt = $client->stmt_init();
                $stmt->prepare($query);
                if(sizeof($value) > 0) $stmt->bind_param($this->getStmtTypes($value),...$value);
                $stmt->execute();
                $form
                    ->clear()
                    ->set_execute(true)
                    ->set_code(200)
                    ->set_affected_rows($stmt->affected_rows)
                    ->set_insert_id($stmt->insert_id);
                $stmt->close();
                $client->close();
            }catch (mysqli_sql_exception $e){
                $form
                    ->clear()
                    ->set_code($e->getCode())
                    ->set_message($e->getMessage());
                $stmt->close();
                $client->close();
            }
        }
        return $form;
    }
    protected function getStmtTypes(array $values) : string {
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
