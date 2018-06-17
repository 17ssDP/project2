<?php
require_once("fns.php");
$artworkID = trim($_GET['id']);
addFooter('detail.php?id='.$artworkID.'', '详情');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
   <meta charset="utf-8">
  <title>details</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/detail.css">
  <link rel="stylesheet" href="../css/lightbox.css">
  <link rel="stylesheet" href="../css/land.css">
  <link rel="stylesheet" href="../css/head.css">
  <script type="text/javascript" src="../js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../js/fns.js"></script>
  <script type="text/javascript" src="../js/detail.js"></script>
</head>
<?php get_html_header() ?>
<body>
<main>
    <?php
    $db = db_connect();
    $query = "SELECT artworkID, title, artist, imageFileName, description, price, yearOfWork, height, width, genre, view, orderID FROM artworks WHERE artworkID = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i',$artworkID);
    $stmt->execute();
    $stmt->store_result();
    //读取查询结果
    $stmt->bind_result($artworkID,$title,$artist, $imageFileName, $description, $price, $date, $height, $width, $genre, $view, $orderID);
    echo $title;
    while($stmt->fetch()) {
        $view++;
        $query = "UPDATE artworks SET view = '".$view."' WHERE artworkID = '".$artworkID."'";
        $db->query($query);
        if($orderID == NULL) {
            $state = "未售出";
        }else {
            $state = "已售出";
        }
    echo '
        <div class="good-details container-fluid">
            <div class="row">
                <h2 class="col-md-12" id="title">'.$title.'</h2>
                <p class="col-md-12">By <a href="search.html" class="author">'.$artist.'</a></p>
            </div>
            <div class="row">
                <div class="col-md-3 good" id="gallery">
                    <a href=".../resources/img/'.$imageFileName.'"><img class="img-fluid" src="../resources/img/'.$imageFileName.'" alt="good"></a>
                </div>
                <div class="col-md-6 container">
                    <p class="row">'.mb_substr($description,0,700,"UTF8").'...</p>
                    <div class="row">
                        <div class="col-md-12 details">
                        <table class="table table-bordered table-hover">
                            <th colspan="2">商品详情</th>
                            <tr>
                                <td>年份:</td>
                                <td>'.$date.'</td>
                            </tr>
                            <tr>
                                <td>尺寸:</td>
                                <td>'.$height.'cm '.$width.'cm</td>
                            </tr>
                            <tr>
                                <td>流派:</td>
                                <td>'.$genre.'</td>
                            </tr>
                            <tr>
                                <td>热度:</td>
                                <td>'.$view.'</td>
                            </tr>
                            <tr>
                                <td>状态:</td>
                                <td>'.$state.'</td>
                            </tr>
                        </table>
                        <h3 class="text-danger">price:<span>'.$price.'$</span></h3>
                        <a href="#" data-toggle="collapse">
                            <span class="badge add-wish font-weight-normal"><i class="fa fa-heart-o"></i> 加入心愿单</span>
                        </a>
                        <a href="#" data-toggle="collapse" id="addCart" data-artworkID="'.$artworkID.'">
                            <span class="badge add-wish font-weight-normal "><i class="fa fa-cart-plus"></i> 加入购物车</span>
                        </a>
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
                            <div class="modal-body">
                            </div>
   
                            <!-- 模态框底部 -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                            </div>
   
                        </div>
                    </div>
                    </div>
                       </div>
                    </div>                  
                </div>
                <div class="col-md-3 more-infor">
                    <ul class="popular-artist list-group">
                        <li class="list-group-item">流行艺术家</li>
                        <li class="list-group-item"><a href="#">cnasdio</a></li>
                        <li class="list-group-item"><a href="#">adfagg</a></li>
                        <li class="list-group-item"><a href="#">afgwerfga</a></li>
                        <li class="list-group-item"><a href="#">arggrvf</a></li>
                        <li class="list-group-item"><a href="#">vbcjdtyj</a></li>
                        <li class="list-group-item"><a href="#">ryukj</a></li>
                        <li class="list-group-item"><a href="#">wrunber</a></li>
                    </ul>
                    <ul class="popular-school list-group">
                        <li class="list-group-item">流行流派</li>
                        <li class="list-group-item"><a href="#">classic</a></li>
                        <li class="list-group-item"><a href="#">cubuim</a></li>
                        <li class="list-group-item"><a href="#">inpression</a></li>
                        <li class="list-group-item"><a href="#">banrosn</a></li>
                        <li class="list-group-item"><a href="#">nangsu</a></li>
                    </ul>
                </div>
            </div>
        </div>
    ';
    }
    //释放结果集
    $stmt->free_result();
    //关闭数据库连接
    $db->close();
    ?>
</main>
</div>
<footer>
</footer>
<?php
if(!havePermission()) {
getLandBox();
}
?>
<script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>


