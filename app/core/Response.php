<?php
namespace App\Core;

class Response {
    private $code = 200;

    public function statusCode($code) {
        $this->code = $code;
        return $this;
    }

    public function response($data) {
        http_response_code($this->code);
        echo json_encode($data);
    }
}