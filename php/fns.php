<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/5/27
 * Time: 16:06
 */
//require_once ('html_header.php');
//require_once ('html_footer.php');
//启动会话
session_start();
//连接数据库
function db_connect() {
    $result = new mysqli('localhost', 'root', 'dadk15dd&ka','Project2');
    $result->set_charset("UTF-8");
    $result->query("SET character_set_client=utf8");
    $result->query("SET character_set_results=utf8");
    if(!$result) {
        throw new Exception('无法连接数据库服务器');
    } else {
        return $result;
    }
}
//检查用户权限
function havePermission() {
    if(isset($_SESSION['userName'])){
        return true;
    }else {
        return false;
    }
}
//销毁会话
function destroySession() {
    //销毁userName变量
    unset($_SESSION["userName"]);
    //销毁会话
    session_destroy();
}
//得到用户ID
function getID() {
    $db = db_connect();
    $userName = $_SESSION['userName'];
    $query = "select * from users where name = '".$userName."'";
    $result = $db->query($query);
    while($user = $result->fetch_assoc()) {
        $userID = $user["userID"];
    }
    return $userID;
}
//得到登录框
function getLandBox() {
    echo '
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
    ';
}
//得到统一的header
function get_html_header() {
    echo '
<header class="container-fluid">
      <nav class="nav-one row">
          <ul class="nav offset-md-8 row">
          ';
    if(havePermission()) {
        echo '
              <li class="nav-item"><a class="nav-link" href="personal.php"><i class="fa fa-user"></i> '.$_SESSION["userName"].'</a></li>
              <li class="nav-item"><a class="nav-link" href="show_cart.php"><i class="fa fa-shopping-cart"></i> 购物车</a></li>
              <li class="nav-item"><a class="nav-link" href="entrance.php" id="logout"><i class="fa fa-sign-out"></i> 登出</a></li>
              ';
    }else {
        echo '
        <li class="nav-item"><a id="show" class="nav-link" href="#" data-toggle="modal" data-target="#land"><i class="fa fa-user"></i> 登录</a></li>
        <li class="nav-item"><a class="nav-link" href="../html/register.html"><i class="fa fa-sign-in"></i> 注册</a></li>
        ';
    }
    echo '
          </ul>
      </nav>
      <div class="row">
          <h1 class="col-md-8">Art Store</h1>
          <div class="search-box form-group col-md-4">
            <input class="searchImage col-md-8" type="text" name="" value=""><input class="col-md-4 searchButton" type="submit" name="" value="搜索"">
          </div>
      </div>
    <!--指针变小手-->
    <nav class="nav-two row">
      <ul class="nav">
        <li class="nav-item"><a class="nav-link" href="entrance.php">首页</a></li>
        <li class="nav-item"><a class="nav-link" href="search.php">搜素</a></li>
        <li class="nav-item"><a class="nav-link" href="detail.html">详情</a></li>
        <li class="nav-item"><a class="nav-link" href="#">发布艺术品</a></li>
      </ul>
    </nav>
  </header>
  <div class="footer"> 足迹：';
  getFooter();
  echo '</div>';
}
function get_html_footer(){
    echo '
        <footer>
	        <p>Produced and miantained by</p>
        </footer>
    </body>
</html>';
}
//修改艺术品
function modifyArtwork() {

}
//添加足迹
function addFooter($url, $name) {
    $newFooter = array("url"=>$url, "name"=>$name);
    array_push($_SESSION['footer'], $newFooter);
    $length = count($_SESSION);
    for($i = count($_SESSION['footer']) - 1; $i > 0 ; $i--) {
        if($_SESSION['footer'][$i]['name'] == $newFooter['name']) {
            $length = $i;
        }
    }
    array_splice($_SESSION['footer'], ($length + 1));
}
//得到足迹
function getFooter() {
    for($i = 0; $i < count($_SESSION['footer']); $i++) {
        echo '<a href="'.$_SESSION['footer'][$i]['url'].'">'.$_SESSION['footer'][$i]['name'].'-></a>';
    }
}
//发布艺术品
function publishArtwork() {

}
//得到提示框
function getPromptBox() {
    echo '
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
                        <button type="button" class="btn btn-secondary modal-button" data-dismiss="modal"></button>
                    </div>

                </div>
            </div>
        </div>
    ';
}
