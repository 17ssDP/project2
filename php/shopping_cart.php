<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/6/12
 * Time: 16:54
 */
require_once('fns.php');
$userID = getID();
$db = db_connect();
$action = $_POST['action'];
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
    //检查是否被买走
//    $soldArtworks = array();
//    $query = "select artwork.orderID from carts, artworks where carts.userID = '".$userID."' and carts.artworkID = artworks.artworkID";
//    $result = $db->query($query);
//    while($row = $result->fetch_assoc()) {
//        if($row['orderID'] != NULL) {
//
//        }
//   }
    //检查是否被删除
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
}else if($action == "getShoppingCart") {
    $html = '';
    $totalMoney = 0;
    $query = "select artworks.artworkID, artworks.title, artworks.artist, artworks.description, artworks.imageFileName, artworks.price, artworks.orderID from carts, artworks 
                  where carts.userID = '".$userID."' and carts.artworkID = artworks.artworkID";
    $result = $db->query($query);
    while($artwork = $result->fetch_assoc()) {
        if($artwork["orderID"] == NULL) {
            $state = "未售出";
        }else {
            $state = "已售出";
        }
        $html .= '
            <div class="good-one row">
                <div class="img col-md-2">
                    <img src="../resources/img/'.$artwork["imageFileName"].'" alt="good">
                </div>
                <div class="col-md-9">
                    <div class="details">
                        <h3 class="name">'.$artwork["title"].'</h3>
                        <h4>By '.$artwork["artist"].'</h4>
                        <p class="author">'.mb_substr($artwork["description"],0,300,"UTF8").'...</p>
                        <p><i class="fa fa-star"></i>价格：$<span>'.$artwork["price"].'</span>&nbsp;&nbsp;&nbsp;&nbsp;状态：<span class="state">'.$state.'</span></p>
                    </div>
                    <div>
                        <button class="detail" onclick="javascript:window.location.href=\'detail.php?id='.$artwork["artworkID"].'\'"><i class="fa fa-share-square-o" aria-hidden="true"></i>  详情</button>
                        <button class="delete" data-artworkID="'.$artwork["artworkID"].'"><i class="fa fa-sign-out"></i>移出购物车</button>
                    </div>
                </div>
            </div>
            ';
        $totalMoney += $artwork["price"];
    }
    $html .= '
        <div class="pay">
            <a id="pay-bt"><i class="fa fa-mail-forward">结款:$</i> <span>'.$totalMoney.'</span></a>
        </div>
        ';
    echo json_encode(['html'=>$html]);
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
    $userID = getID();
    global $db;
    $query = "delete from carts where userID = '".$userID."'";
    $result = $db->query($query);
    if($result) {
        error_log('清空成功');
        error_log($result);
    }
}
?>