<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/5/24
 * Time: 22:17
 */
require_once("fns.php");
//连接数据库
$conn = db_connect();
//获取注册信息
$username = trim($_POST["userName"]);
$email = trim($_POST["email"]);
$password = trim($_POST["password"]);
$phone = trim($_POST["phone"]);
$address = trim($_POST["address"]);
$balance = 0;
$result = $conn->query("select * from users where name='".$username."'");
if(!$result) {
    throw new Exception('Could not ececute query');
} else if($result->num_rows > 0){
    echo false; //此处一定要用echo
} else {
    $result = $conn->query("insert into users values ('NULL', '".$username."', '".$email."', '".$password."', '".$phone."', '".$address."', '".$balance."')");
    if(!$result) {
        throw new Exception('注册失败，请稍后再试');
    } else {
        $_SESSION['userName'] = $username;
        echo true;
    }
}
?>