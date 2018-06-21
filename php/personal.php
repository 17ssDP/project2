<?php
require_once("fns.php");
if(!havePermission()){
    require_once("entrance.php");
    exit;
};
addFooter('personal.php', '个人信息');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Personal Information</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/personal.css">
  <link rel="stylesheet" href="../css/head.css">
  <script type="text/javascript" src="../js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../js/fns.js"></script>
  <script type="text/javascript" src="../js/personal.js"></script>
  <script type="text/javascript" src="../js/image-style1.js"></script>
</head>
<body>
<?php
get_html_header();
$db = db_connect();
$userName = $_SESSION['userName'];
$query = "select * from users where name = '".$userName."'";
$result = $db->query($query);
while($user = $result->fetch_assoc()) {
    $userID = $user["userID"];
echo '
<main class="container">
    <div class="information container card">
      <table class="table table-hover">
        <thead>
            <tr>
                <th colspan="2">用户信息</th>
            </tr>
        </thead>
        <tr>
          <td>用户：</td>
          <td>'.$user["name"].'</td>
        </tr>
        <tr>
          <td>电话：</td>
          <td>'.$user["tel"].'</td>
        </tr>
        <tr>
          <td>邮箱：</td>
          <td>'.$user["email"].'</td>
        </tr>
        <tr>
          <td>地址：</td>
          <td>'.$user["address"].'</td>
        </tr>
        <tr>
          <td>余额：</td>
          <td id="balance">'.$user["balance"].'</td>
        </tr>
      </table>
      <div class="row">
        <input id="money" class="col-md-3 offset-md-2" type="number" value="" name="">
        <input id="recharge" class="btn offset-md-3" type="button" name="" value="充值信仰">
      </div>
      <p id="error" class="offset-md-2" style="height: 20px"></p>
    </div>';
    }
?>
<div id="accordion">
    <div class="card">
        <div class="card-header">
            <a class="card-link" data-toggle="collapse" href="#collapseOne">
                <h3>我的艺术品：</h3>
            </a>
        </div>
        <div id="collapseOne" class="collapse show" data-parent="#accordion">
            <div class="card-body">
                 <div class="upload">
                      <table class="table">
                          <thead>
                          <tr>
                              <th>艺术品名称</th>
                              <th>上传日期</th>
                              <th>状态</th>
                              <th>修改</th>
                              <th>删除</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                          error_log($userID);
                          $query = "select * from artworks where ownerID = '".$userID."'";
                          $result = $db->query($query);
                          while($row = $result->fetch_assoc()) {
                              if($row['orderID'] == NULL) {
                                  $state = "未售出";
                              }else {
                                  $state = "已售出";
                              }
                              echo'<tr>
                                        <td><a href="detail.php?id='.$row['artworkID'].'">'.$row['title'].'</a></td>
                                        <td>'.$row["timeReleased"].'</td>
                                        <td class="state">'.$state.'</td>
                                        <td><button class="btn change" data-artworkID="'.$row['artworkID'].'">修改</button></td>
                                        <td><button class="btn delete" data-artworkID="'.$row['artworkID'].'">删除</button></td>
                                   </tr>
                            ';}
                          ?>
                          </tbody>
                      </table>
                 </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                <h3>我的订单:</h3>
            </a>
        </div>
        <div id="collapseTwo" class="collapse" data-parent="#accordion">
            <div class="card-body">
                    <div class="buy">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>订单编号</th>
                                <th>商品名称</th>
                                <th>订单时间</th>
                                <th>订单金额</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $query = "select * from orders where ownerID = '".$userID."'";
                            $result = $db->query($query);
                            while($row = $result->fetch_assoc()) {
                                $orderID = $row["orderID"];
                                $sum = $row["sum"];
                                $timeCreated = $row["timeCreated"];
                                echo '<tr>';
                                echo '<td>'.$orderID.'</td>';
                                echo '<td>';
                                $query = "select * from artworks where orderID = '".$orderID."'";
                                $msg = $db->query($query);
                                while($artwork = $msg->fetch_assoc()) {
                                    echo '<a href="../php/detail.php?id='.$artwork['artworkID'].'">'.$artwork["title"].'</a>';
                                    echo '</br>';
                                }
                                echo '</td>';
                                echo '<td>'.$timeCreated.'</td>';
                                echo '<td>$'.$sum.'</td>';
                                echo '</tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
                <h3>我的卖出：</h3>
            </a>
        </div>
        <div id="collapseThree" class="collapse" data-parent="#accordion">
            <div class="card-body">
                <div class="sell">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th>名称</th>
                            <th>卖出时间</th>
                            <th>价格</th>
                            <th>购买人信息</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = "select * from artworks where ownerID = '".$userID."' and orderID != '".NULL."'";
                        $result = $db->query($query);
                        while($row = $result->fetch_assoc()) {
                            $artworkID = $row["artworkID"];
                            $title = $row["title"];
                            $price = $row["price"];
                            //得到订单的详细信息
                            $query = "select * from orders where orderID = '".$row["orderID"]."'";
                            $msg = $db->query($query);
                            while($order = $msg->fetch_assoc()) {
                                $timeCreated = $order["timeCreated"];
                                $buyerID = $order["ownerID"];
                            }
                            //得到购买人的信息
                            $query = "select * from users where userID = '".$buyerID."'";
                            $msg = $db->query($query);
                            while($user = $msg->fetch_assoc()) {
                                $name = $user["name"];
                                $email = $user["email"];
                                $tel = $user["tel"];
                                $address = $user["address"];
                            }
                            echo '<tr>';
                            echo '<td><a href="../php/detail.php?id='.$artworkID.'">'.$title.'</a></td>';
                            echo '<td>'.$timeCreated.'</td>';
                            echo '<td>$'.$price.'</td>';
                            echo '<td>
                        <p>姓名：'.$name.'</p>
                        <p>邮箱：'.$email.'</p>
                        <p>电话：'.$tel.'</p>
                        <p>地址：'.$address.'</p>
                        </td>';
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
  </main>
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
<!-- 模态框 -->
<div class="modal fade" id="confirm_delete">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="confirm"></button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>