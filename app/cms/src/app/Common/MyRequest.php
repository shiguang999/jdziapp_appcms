<?php
namespace App\Common;
use PhalApi\Request;

class MyRequest extends Request {

    public function genData($data) {
       if (!isset($data)||!is_array($data)){
           $data = $_POST;//改为只接受post
       }
       return isset($data['data'])? base64_decode($data['data']) :array();
    }
}
