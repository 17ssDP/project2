<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/6/16
 * Time: 14:05
 */
require_once('fns.php');
$db = db_connect();
$artworkID = $_POST['artworkID'];
$userID = getID();
$success = false;
$message = array();
$query = "select imageFileName from artworks where artworkID = '".$artworkID."'";
$result = $db->query($query);
while($row = $result->fetch_assoc()) {
    $imageFileName = $row['imageFileName'];
    error_log($imageFileName);
}
if($imageFileName) {
    if(file_exists("../resources/img/" . $imageFileName)){
        unlink("../resources/img/" . $imageFileName);
        $query = "delete from artworks where artworkID = ? and ownerID = ?";
        $result = $db->prepare($query);
        $result->bind_param('dd',$artworkID, $userID);
        $result->execute();
        if($result->affected_rows > 0) {
            $success = true;
        }
        else{
            $success = false;
        }
    }else {
        $success = false;
    };
}else {
    $success = false;
}
$message['success'] = $success;
echo $success;

