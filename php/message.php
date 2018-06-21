<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
* Date: 2018/6/20
* Time: 12:10
*/
require_once('fns.php');
if(!havePermission()) {
    require_once('entrance.php');
    exit;
}
addFooter('message.php', "信箱");
$db = db_connect();
$userID = getID();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Publish Artworks</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/publish_artwork.css">
    <link rel="stylesheet" href="../css/head.css">
    <link rel="stylesheet" href="../css/message.css">
</head>
<body>
<?php get_html_header(); ?>
    <main class="container-fluid row">
        <ul class="nav nav-tabs flex-column col-md-3 offset-md-1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" ><h4>收件箱</h4></a>
            </li>
            <?php
            //读取信件
            $query = "select receivemessages.receiveTime, receivemessages.messageID, receivemessages.isRead, users.name from  receivemessages, users 
                      where receivemessages.receiverID = ".$userID." and receivemessages.senderID = users.userID order by receiveTime desc";
            $result = $db->query($query);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    if($row['isRead'] == 0) {
                    echo '
                <li class="nav-item">
                    <a class="nav-link unread" data-toggle="tab" href="#receive'.$row['messageID'].'" data-messageID="'.$row['messageID'].'"><i class="fa fa-envelope-o" aria-hidden="true"></i> '.$row['name'].'->'.$row['receiveTime'].'</a>
                </li>
                ';
                    }else {
                        echo '
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#receive'.$row['messageID'].'"><i class="fa fa-envelope-open-o" aria-hidden="true"></i> '.$row['name'].'->'.$row['receiveTime'].'</a>
                </li>
                ';
                    }
                }
            }
            ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab"><h4>发件箱</h4></a>
            </li>
            <?php
            //读取我发送的邮件
            $query = "select sendmessages.sendTime, sendmessages.messageID, users.name from  sendmessages, users
                      where sendmessages.senderID = ".$userID." and sendmessages.receiverID = users.userID order by sendTime desc";
            $result = $db->query($query);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#send'.$row['messageID'].'">'.$row['sendTime'].'->'.$row['name'].'</a>
                </li>
                ';
                }
            }
            ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#write"><h4>写信</h4></a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content col-md-7">
            <?php
            //读取我收到的信息
            $query = "select receivemessages.message, receivemessages.messageID, users.name from  receivemessages, users 
                                  where receivemessages.receiverID = ".$userID." and receivemessages.senderID = users.userID ";
            $result = $db->query($query);
            while($row = $result->fetch_assoc()) {
                    echo'
                        <div id="receive'.$row['messageID'].'" class="container tab-pane fade"><br>
                            <div class="card">
                                <div class="card-header">From:'.$row['name'].'</div>
                                <div class="card-body">
                                    <p class="card-text">'.$row['message'].'</p>
                                </div>
                                <div class="card-footer"><button class="btn delete-receive" data-messageID="'.$row['messageID'].'">删除</button></div>
                            </div>
                        </div>
                            ';
            }
            //读取我发送的信息
            $query = "select sendmessages.sendTime, sendmessages.messageID, sendmessages.message, users.name from  sendmessages, users
                         where sendmessages.senderID = ".$userID." and sendmessages.receiverID = users.userID ";
            $result = $db->query($query);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo'
                        <div id="send'.$row['messageID'].'" class="container tab-pane fade"><br>
                            <div class="card">
                                <div class="card-header">To: '.$row['name'].'</div>
                                <div class="card-body">
                                    <p class="card-text">'.$row['message'].'</p>
                                </div>
                                <div class="card-footer"><button class="btn delete-send" data-messageID="'.$row['messageID'].'">删除</button></div>
                                </div>
                        </div>
                            ';
                }
            }else {
                echo '
                    <div id="menu2" class="container tab-pane fade"><br>
                         <div class="card">
                            <div class="card-header">已发送</div>
                            <div class="card-body">
                                <p class="card-text">您还未写过信</p>
                            </div>
                            <div class="card-footer">底部</div>
                         </div>
                    </div>
                ';
            }
            ?>
            <div id="write" class="container tab-pane"><br>
                <div class="card">
                    <div class="card-header">
                        <div class="form-group">
                            <label for="letterReceive">To:</label> <p class="receiver_error"></p>
                            <input type="text" class="form-control" id="letterReceiver">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="comment">内容:</label><p class="message_error"></p>
                            <textarea class="form-control" rows="5" id="message"></textarea>
                        </div>
                    </div>
                    <div class="card-footer"><button class="btn" id="sendLetter">发送</button><p class="sendSuccess"></p></div>
                </div>
            </div>
        </div>
    </main>
</body>
<script type="text/javascript" src="../js/jquery-3.3.1.js"></script>
<script type="text/javascript" src="../js/message.js"></script>
<script type="text/javascript" src="../js/fns.js"></script>
<script type="text/javascript" src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>

