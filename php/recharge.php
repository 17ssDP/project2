<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/6/13
 * Time: 20:43
 */
require_once('fns.php');
//启动会话
session_start();
//$userName = $_SESSION['user'];
$userName = "master";
$db = db_connect();
$money = $_POST['money'];
$query = "select balance from users where name = '".$userName."'";
$result = $db->query($query);
while($row = $result->fetch_assoc()) {
    $balance = $row['balance'];
}
$balance += $money;
$query = "update users set balance = '".$balance."' where name = '".$userName."'";
try{
    $db->query($query);
}catch (Exception $e) {
    echo false;
}
echo true;

