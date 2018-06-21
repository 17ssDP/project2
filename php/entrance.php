<?php
require_once('fns.php');
$_SESSION['footer'] = array();
addFooter('entrance.php', '首页');
//启动会话
//session_start();
//if(isset($_POST['username'])) {
//    $_SESSION['user'] = trim($_POST['username']);
//    echo "jfakdf";
//}
$db = db_connect();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Art Store</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/entrance.css">
    <link rel="stylesheet" href="../css/land.css">
    <link rel="stylesheet" href="../css/jquery-ui.min.css">
    <script type="text/javascript" src="../js/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../js/fns.js"></script>
    <script type="text/javascript" src="../js/land.js"></script>
    <script>
    </script>
</head>

<body class="container-fluid">
<nav class="row navbar navbar-expand-sm navbar-dark">
    <h1 class="col-md-2">Art Store</h1>
    <p class="col-md-6">where you find GENIUS and EXTROORDINARY</p>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse col-md-4" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <?php
            if(!isset($_SESSION["userName"])) {
                echo '
            <li class="nav-item"><a class="nav-link" href="entrance.php">首页</a></li>
            <li class="nav-item"><a class="nav-link" href="search.php">搜索</a></li>
            <li class="nav-item"><a id="show" class="nav-link" href="#" data-toggle="modal" data-target="#land">登录</a></li>
            <li class="nav-item"><a class="nav-link" href="../html/register.html">注册</a></li>
                ';
            } else {
                echo '
            <li class="nav-item"><a class="nav-link" href="entrance.php">首页</a></li>
            <li class="nav-item"><a class="nav-link" href="search.php">搜索</a></li>
            <li class="nav-item"><a class="nav-link" href="personal.php">个人信息</a></li>
            <li class="nav-item"><a class="nav-link" id="logout" href="#">登出</a></li>
                ';
            }
            ?>
        </ul>
    </div>
</nav>
<br>
<div class="container-fluid">
    <div id="demo" class="carousel slide" data-ride="carousel">
        <!-- 指示符 -->
        <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            <li data-target="#demo" data-slide-to="1"></li>
            <li data-target="#demo" data-slide-to="2"></li>
        </ul>
        <!-- 轮播图片 -->
        <div class="carousel-inner">
            <?php
            $query = "SELECT * FROM artworks where orderID is NULL ORDER BY view DESC limit 3";
            $result = $db->query($query);
            $number = 1;
            while($row = $result->fetch_assoc()) {
                if($number == 1) {
                    echo '<div class="carousel-item active">
                            <img class="w-100" src="../resources/img/'.$row["imageFileName"].'">
                            <div class="carousel-caption">
                                <h2>'.$row["title"].'</h2>
                                <p>'.$row["description"].'</p>
                                <input type="button" name="" value="Learn More" onclick="javascript:window.location.href=\'detail.php?id='.$row["artworkID"].'\'"> 
                            </div>
                          </div>';
                }else {
                    echo '<div class="carousel-item">
                            <img class="w-100" src="../resources/img/'.$row["imageFileName"].'">
                             <div class="carousel-caption">
                                <h2>'.$row["title"].'</h2>
                                <p>'.$row["description"].'</p>
                                <input type="button" name="" value="Learn More" onclick="javascript:window.location.href=\'detail.php?id='.$row["artworkID"].'\'">
                             </div>
                          </div>';
                }
                $number++;
            }
            ?>
        </div>
        <!-- 左右切换按钮 -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
</div>
<!-- 模态框 -->
<div class="modal fade" id="land">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- 模态框头部 -->
            <div class="modal-header title">
                <h3 class="modal-title">欢迎登录Art Store</h3>
                <h4 id="close" class="close" data-dismiss="modal"><i class="fa fa-close fa-2x"></i></h4>
            </div>

            <!-- 模态框主体 -->
            <div class="modal-body">
                <form class="content" id="signup" method="post">
                    <input id="username" name="username" type="text" placeholder="邮箱/用户名" value="master">
                    <div id="name-error"></div>
                    <input id="password" name="password" type="password" placeholder="密码" value="mAs1er">
                    <div id="password-error"></div>
                    <div class="test">
                        <div class="code"></div>
                        <input type="text" id="code" value="" placeholder="验证码">
                        <div id="code-error"></div>
                    </div>
                    <input type="button" name="button" id="button" value="登录">
                </form>
            </div>

        </div>
    </div>
</div>
<section class="row">
    <?php
    $query = "SELECT * FROM artworks where orderID is NULL ORDER BY timeReleased DESC limit 3";
    $result = $db->query($query);
    while($artwork = $result->fetch_assoc()) {
        echo '
        <div class="intro-one col-md-4">
        <a href="#"><img src="../resources/img/'.$artwork["imageFileName"].'" alt="artwork"></a>
        <h2>'.$artwork["title"].'</h2>
        <p>'.mb_substr($artwork["description"],0,300,"UTF8").'...</p>
        <a href="detail.php?id='.$artwork["artworkID"].'" role="button">View Details</a>
    </div>
        ';
    }
    ?>
</section>
<footer>
    <p>Produced and miantained by</p>
</footer>
<!--<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
<script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>