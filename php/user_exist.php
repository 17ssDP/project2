<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/5/30
 * Time: 16:00
 */

require_once("fns.php");
$conn = db_connect("users");
$username = $_REQUEST['name'];
$result = $conn->query("select * from users where name='".$username."'");
if(!$result) {
    throw new Exception('Could not ececute query');
} else {
    echo $result->num_rows > 0; //此处一定要用echo
}
?>