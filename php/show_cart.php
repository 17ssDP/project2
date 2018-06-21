<?php
require_once('fns.php');
if(!havePermission()){
    require_once("entrance.php");
    exit;
};
addFooter('show_cart.php', '购物车');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Shopping-cart Interface</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/shopping-cart.css">
    <link rel="stylesheet" href="../css/jquery-ui.min.css">
    <link rel="stylesheet" href="../css/head.css">
</head>

<body>
<?php get_html_header() ?>
<main>
    <div class="title">
        <img src="../images/photo/shopping-cart.jpg" alt="shopping-cart">
        <h2>购物车</h2>
    </div>
    <section class="container">
        <?php
//        $db = db_connect();
//        $userID = getID();
//        $totalMoney = 0;
//        $query = "select artworks.artworkID, artworks.title, artworks.artist, artworks.description, artworks.imageFileName, artworks.price, artworks.orderID from carts, artworks
//                  where carts.userID = '".$userID."' and carts.artworkID = artworks.artworkID";
//        $result = $db->query($query);
//        while($artwork = $result->fetch_assoc()) {
//            if($artwork["orderID"] == NULL) {
//                $state = "未售出";
//            }else {
//                $state = "已售出";
//            }
//            echo '
//            <div class="good-one row">
//                <div class="img col-md-2">
//                    <img src="../resources/img/'.$artwork["imageFileName"].'" alt="good">
//                </div>
//                <div class="col-md-9">
//                    <div class="details">
//                        <h3 class="name">'.$artwork["title"].'</h3>
//                        <h4>By '.$artwork["artist"].'</h4>
//                        <p class="author">'.mb_substr($artwork["description"],0,300,"UTF8").'...</p>
//                        <p><i class="fa fa-star"></i>价格：$<span>'.$artwork["price"].'</span>&nbsp;&nbsp;&nbsp;&nbsp;<span> 状态：'.$state.'</span></p>
//                    </div>
//                    <div>
//                        <button class="detail" onclick="javascript:window.location.href=\'detail.php?id='.$artwork["artworkID"].'\'"><i class="fa fa-share-square-o" aria-hidden="true"></i>  详情</button>
//                        <button class="delete" data-artworkID="'.$artwork["artworkID"].'"><i class="fa fa-sign-out"></i>移出购物车</button>
//                    </div>
//                </div>
//            </div>
//            ';
//            $totalMoney += $artwork["price"];
//        }
//        echo '
//        <div class="pay">
//            <a id="pay-bt"><i class="fa fa-mail-forward">结款:$</i> <span>'.$totalMoney.'</span></a>
//        </div>
//        ';
        ?>
    </section>
</main>
<footer>
<!--    <ul>-->
<!--        <li><a href="#"><i class="fa fa-chevron-left"></i></a></li>-->
<!--        <li><a href="#">1</a></li>-->
<!--        <li><a href="#">2</a></li>-->
<!--        <li><a href="#">3</a></li>-->
<!--        <li><a href="#">4</a></li>-->
<!--        <li><a href="#">5</a></li>-->
<!--        <li><a href="#">6</a></li>-->
<!--        <li><a href="#">7</a></li>-->
<!--        <li><a href="#">8</a></li>-->
<!--        <li><a href="#">9</a></li>-->
<!--        <li><a href="#">10</a></li>-->
<!--        <li><a href="#"><i class="fa fa-chevron-right"></i></a></li>-->
<!--    </ul>-->
</footer>
<!-- 模态框 -->
<div class="modal fade" id="information">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <!-- 模态框头部 -->
            <div class="modal-header">
                <h3 class="modal-title">Art Store</h3>
                <h4 id="close" class="close" data-dismiss="modal"><i class="fa fa-close fa-2x"></i></h4>
            </div>

            <!-- 模态框主体 -->
            <div class="modal-body"></div>

            <!-- 模态框底部 -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript" src="../js/jquery-3.3.1.js"></script>
<script type="text/javascript" src="../js/fns.js"></script>
<script type="text/javascript" src="../js/shopping-cart.js"></script>
<script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
