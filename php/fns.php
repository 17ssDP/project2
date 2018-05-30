<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/5/27
 * Time: 16:06
 */
function db_connect($database) {
    $result = new mysqli('localhost', 'root', 'dadk15dd&ka', $database);
    if(!$result) {
        throw new Exception('无法连接数据库服务器');
    } else {
        return $result;
    }
}