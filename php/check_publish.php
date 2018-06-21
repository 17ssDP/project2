<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/6/15
 * Time: 19:42
 */
require_once('fns.php');
date_default_timezone_set('PRC');
$timeCreated = date("Y-m-d H:i:s");
//$userName = $_SESSION['userName'];
//$userID = getID();
$db = db_connect();
$userID = getID();
$title = $_POST['title'];
$artist = $_POST['artist'];
$description = $_POST['description'];
$yearOfWork = $_POST['yearOfWork'];
$genre = $_POST['genre'];
$height = $_POST['height'];
$width = $_POST['width'];
$price = $_POST['price'];
$view = 0;
$action = $_POST['action'];
$success = true;

//上传艺术品
if($action == "publish") {
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'] / 1024;
    //得到文件扩展名
    $fileType = substr(strrchr($fileName, '.'), 1);
    //将艺术品详情写入数据库
    $query = "insert into artworks (artist, imageFileName, title, description, yearOfWork, genre, width, height, price, view, ownerID, timeReleased) values (?,?,?,?,?,?,?,?,?,?,?,NULL)";
    $result = $db->prepare($query);
    $result->bind_param('ssssdsddddd',$artist, $fileName, $title, $description, $yearOfWork, $genre, $width, $height, $price, $view, $userID);
    $result->execute();
    if($result->affected_rows > 0){
        $artworkID = $result->insert_id;
    }else {
        $success = false;
        error_log("插入数据失败！");
    };
    //设置路径
    $imageFileName = "$artworkID" . "." . $fileType;
    try {
        $db->query("update artworks set imageFileName = '" . $imageFileName . "' where artworkID = '" . $artworkID . "'");
    }catch (Exception $exception) {
        $success = false;
        error_log("更新文件路径失败");
    }
    move_uploaded_file($_FILES['file']['tmp_name'], "../resources/img/" . $imageFileName);
}

//修改艺术品
if($action == "modify") {
    $artworkID = $_POST['artworkID'];
    //判断文件是否被修改
    if(isset($_FILES['file'])) {
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileType = substr(strrchr($fileName, '.'), 1);
        $imageFileName = "$artworkID" . "." . $fileType;
        if(file_exists("../resources/img/" . $imageFileName)){
            unlink("../resources/img/" . $imageFileName);
        };
        move_uploaded_file($_FILES['file']['tmp_name'], "../resources/img/" . $imageFileName);
    }else{
        $query = "select imageFileName from artworks where artworkID = '".$artworkID."'";
        $result = $db->query($query);
        while($row = $result->fetch_assoc()) {
            $imageFileName = $row['imageFileName'];
        }
    }
//    error_log("fasdf");
//    error_log(isset($_FILES['file']) == false);
    $query = "update artworks set artist = ?, imageFileName = ?, title = ?, description = ?, yearOfWork = ?, genre = ?, width = ?, height = ?, price = ? where artworkID = '".$artworkID."'";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssssdsddd",$artist, $imageFileName, $title, $description, $yearOfWork, $genre, $width, $height, $price);
    $stmt->execute();
    if($stmt->affected_rows == 0) {
        error_log("修改文件失败！");
        $success = false;
    }
    //如果用户修改了文件则保存新的文件
    error_log($imageFileName);
    //发送站内信
    $query = "select users.userID from users, carts where carts.artworkID = '".$artworkID."' and carts.userID = users.userID";
    $result = $db->query($query);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $receiverID = $row['userID'];
        }
        $query = "select imageFileName from artworks where artworkID = '".$artworkID."'";
        $result = $db->query($query);
        while($row = $result->fetch_assoc()) {
            $imageFileName = $row['imageFileName'];
            error_log($imageFileName);
        }
        $message = "尊敬的用户："."您购物车中的".$title."的信息被卖家修改，请注意其中的变化";
        $senderID = 1;
        error_log('xiamiandexinxi');
        error_log(sendMessage($message,$receiverID, $senderID));
    }
}
$json_array = array('success'=>$success);
$json = json_encode($json_array);
echo $json;