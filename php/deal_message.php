<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/6/20
 * Time: 13:11
 */
require_once('fns.php');
$db = db_connect();
$userID = getID();
$action = $_POST['action'];
error_log("fasdfasdf");
$success = true;
error_log($action);
if($action == "delete-send") {
    $messageID = $_POST['messageID'];
    $query = "delete from sendmessages where messageID = '".$messageID."' and senderID = '".$userID."'";
    $result = $db->prepare($query);
    $result->execute();
    if($result->affected_rows == 0) {
        $success = false;
    }
    error_log($result->affected_rows);
}
if($action == "delete-receive") {
    $messageID = $_POST['messageID'];
    $query = "delete from receivemessages where messageID = '".$messageID."' and receiverID = '".$userID."'";
    $result = $db->prepare($query);
    $result->execute();
    if($result->affected_rows == 0) {
        $success = false;
    }
}
if($action == "send-message") {
    error_log("faskdjfffa");
    $message = $_POST['message'];
    $receiver = &$_POST['receiver'];
    $query = "select userID from users where name = '".$receiver."'";
    $result = $db->query($query);
    while($row = $result->fetch_assoc()) {
        $receiverID = $row['userID'];
    }
    if(isset($receiverID)) {
        $success = sendMessage($message, $receiverID, $userID);
    }else {
        $success = false;
    }
}
if($action == "changeState") {
    $isRead = 1;
    $messageID = $_POST['messageID'];
    error_log("kanxianmian");
    error_log($messageID);
    $query = "update receivemessages set isRead = '".$isRead."' where messageID = '".$messageID."'";
    $db->query($query);
}
echo $success;