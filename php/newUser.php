<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/5/24
 * Time: 22:17
 */
require_once("fns.php");
header("Content-type: application/json");
//获取注册信息
$username = trim($_POST["name"]);
$email = trim($_POST["email"]);
$password = trim($_POST["password"]);
$phone = trim($_POST["phone"]);
$address = trim($_POST["address"]);
$balance = 0;
//$userID = 25;
//$username = "madfgsdd";
//$email = "kjakd";
//$password = "akdfa";
//$tel = "akdjfa";
//$address = "fadlsa";
//$balance = 1000;
//连接数据库
//$db = new mysqli('localhost', 'root', 'dadk15dd&ka', 'users');
////检查尝试建立连接的结果
//if (mysqli_connect_errno()) {
//    echo '<p>Error: Could not connect to database</p>';
//    exit;
//}
////插入数据库
//$query = "INSERT INTO users VALUES (?, ?, ?, ?, ?, ?, ?)";
//$stmt = $db->prepare($query);
//$stmt->bind_param('ssssssd',$userID, $username, $email, $password, $tel, $address, $balance);
//$stmt->execute();
////关闭数据库连接
//$db->close();
register($username, $email, $password, $phone, $address, $balance);
function register($username, $email, $password, $tel, $address, $balance) {
    $conn = db_connect("users");
    //插入数据库
    $password = password_hash(".$password.", PASSWORD_DEFAULT);
    $result = $conn->query("insert into users values ('NULL', '".$username."', '".$email."', '".$password."', '".$tel."', '".$address."', '".$balance."')");
    if(!$result) {
        throw new Exception('注册失败，请稍后再试');
    }
}
?>