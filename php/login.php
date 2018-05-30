<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/5/26
 * Time: 10:58
 */
require_once("fns.php");
//启动会话
session_start();
//获取登录信息
$temp = trim($_POST['username']);
$reg = "/^(\w)+(\.\w+)*@(\w)+((\.\w{2,3}){1,3})$/";
$password = trim($_POST['password']);
//连接数据库
$db_conn = db_connect("users");
//确定用户为邮箱登录还是用户名登录，查询数据库
if (preg_match($reg, $temp)) {
    $result = $db_conn->query("select * from users where email = '".$temp."' and password = '".$password."'");
    $query = "SELECT name FROM users WHERE email = ?";
    $stmt = $db_conn->prepare($query);
    $stmt->bind_param('s',$temp);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userName);
    while($stmt->fetch()) {
        echo '';
    }
} else {
    $result = $db_conn->query("select * from users where name = '".$temp."' and password = '".$password."'");
    $userName = $temp;
}
//注册会话变量
if ($result->num_rows) {
    $_SESSION['vaild_user'] = $userName;
    echo "登录成功! Hello $userName";
} else {
    echo '登录失败';
}
?>