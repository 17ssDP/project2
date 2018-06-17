<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/5/27
 * Time: 13:04
 */
require_once('fns.php');
$action = $_POST['action'];
if($action == "logout") {
    //销毁会话
    session_destroy();
    echo true;
}
?>
