<?php
namespace App\Core;

abstract class Middleware {

    private $response = null;
    private $db = null;

    abstract function next($params);

    public function response() {
        if ($this->response === null) $this->response = new Response();
        return $this->response;
    }

    public function db() {
        if ($this->db === null) $this->db = new Database();
        return $this->db;
    }
}