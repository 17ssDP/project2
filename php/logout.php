<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/5/27
 * Time: 13:04
 */
//启动会话
session_start();
//保存用户名
$old_user = $_SESSION['vaild_user'];
//销毁vaild_user变量
unset($_SESSION['vaild_user']);
//销毁会话
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Log Out</title>
</head>
<body>
<h1>Log Out</h1>
<?php
    if(!empty($old_user)) {
        echo $old_user;
        echo '您已经登出';
    } else {
        //如果他们没有登陆但却来到这个页面
        echo '<p>您还未登录，故您还未登出</p>';
    }
?>
</body>
</html>
