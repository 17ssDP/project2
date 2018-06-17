<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/6/12
 * Time: 16:54
 */
require_once('fns.php');
//session_start();
//$userName = $_SESSION['user'];
$userName = "master";
$db = db_connect();
//$artworkID = 26;
$action = $_POST['action'];
$query = "select userID from users where name = '".$userName."'";
$result = $db->query($query);
while($row = $result->fetch_assoc()) {
    $userID = $row['userID'];
}
if($action == "add") {
    $artworkID = $_POST['artworkID'];
    $query = "select * from carts where userID = '".$userID."' and artworkID = '".$artworkID."'";
    $result = $db->query($query);
    if($result->num_rows > 0) {
        echo 'artwork already exist';
    } else {
        $query = "select orderID from artworks where artworkID = '".$artworkID."'";
        $result = $db->query($query);
        while($row = $result->fetch_assoc()) {
            $orderID = $row['orderID'];
        }
        if($orderID != NULL) {
            echo 'good sold';
        } else {
            $query = "insert into carts values ('NULL', '".$userID."', '".$artworkID."')";
            try {
                $db->query($query);
            } catch(Exception $e) {
                echo "fail to add";
            }
            echo "successfully add";
        }
    }
} else if($action == "delete") {
    $artworkID = $_POST['artworkID'];
    $query = "delete from carts where userID = '".$userID."' and artworkID = '".$artworkID."'";
    $result = $db->query($query);
    if($result) {
        echo true;
    }
} else if($action == "payment") {
    //检查余额是否足够
    $query = "select artworks.price from carts, artworks 
                  where carts.userID = '".$userID."' and carts.artworkID = artworks.artworkID";
    $result = $db->query($query);
    $totalMoney = 0;
    while($row = $result->fetch_assoc()) {
        $totalMoney += $row['price'];
    }
    $query = "select balance from users where userID = '".$userID."'";
    $result = $db->query($query);
    while($row = $result->fetch_assoc()) {
        $balance = $row['balance'];
    }
    if($balance >= $totalMoney) {
        //扣除相应金额
        $balance -= $totalMoney;
        $query = "update users set balance = '".$balance."' where userID = '".$userID."'";
        $db->query($query);
        //添加订单
        date_default_timezone_set('PRC');
        $timeCreated = date("Y-m-d H:i:s");
        $query = "insert into orders values ('NULL', '".$userID."', '".$totalMoney."', '".$timeCreated."')";
        $db->query($query);
        //将订单信息添加到商品
        addOrderToArtworks();
        //增加卖家的balance
        addSellerBalance();
        //清空购物车
        clearCart();
        echo true;
    } else {
        echo false;
    }
}
function addOrderToArtworks() {
    global $userID;
    global $db;
    $query = "select orderID from orders where ownerID = '".$userID."' order by timeCreated DESC limit 1";
    $result = $db->query($query);
    while($row = $result->fetch_assoc()) {
        $orderID = $row['orderID'];
    }
    $query = "select artworkID from carts where userID = '".$userID."'";
    $result = $db->query($query);
    while($row = $result->fetch_assoc()) {
        $query = "update artworks set orderID = '".$orderID."' where artworkID = '".$row["artworkID"]."'";
        $db->query($query);
    }
}
function addSellerBalance() {
    global $userID;
    global $db;
    //查询买家的购物车
    $query = "select artworkID from carts where userID = '".$userID."'";
    $result = $db->query($query);
    while($row = $result->fetch_assoc()){
        $artworkID = $row["artworkID"];
        //查询卖家ID
        $query = "select ownerID from artworks where artworkID = '".$artworkID."'";
        $owner = $db->query($query);
        while($user = $owner->fetch_assoc()) {
            $userID = $user['ownerID'];
        }
        //读取卖家的balance
        $query = "select balance from users where userID = '".$userID."'";
        $msg  = $db->query($query);
        while($user = $msg->fetch_assoc()) {
            $balance = $user["balance"];
        }
        //增加卖家的balance
        global $totalMoney;
        $balance += $totalMoney;
        $query = "update users set balance = '".$balance."' where userID = '".$userID."'";
        $db->query($query);
    }
}
function clearCart() {
    global $userID;
    global $db;
    $query = "delete from carts where userID = '".$userID."'";
    $db->query($query);
}
?>