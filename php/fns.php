<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/5/27
 * Time: 16:06
 */
//require_once ('html_header.php');
//require_once ('html_footer.php');
function db_connect() {
    $result = new mysqli('localhost', 'root', 'dadk15dd&ka','Project2');
    if(!$result) {
        throw new Exception('无法连接数据库服务器');
    } else {
        return $result;
    }
}
function get_html_header($title) {
    echo '
<header>
    <nav class="nav-one">
      <ul>
        <li><a href="#"><i class="fa fa-user"></i>'.$title.'</a></li>
        <li><a href="Shopping-cart.html"><i class="fa fa-shopping-cart"></i> 购物车</a></li>
        <li><a href="entrance.html"><i class="fa fa-sign-out"></i> 登出</a></li>
      </ul>
    </nav>
    <h1>Art Store</h1>
    <div class="search-box">
      <input type="text" name="" value=""><input type="submit" name="" value="搜索" onclick="javascript:window.location.href=\'search.html\'">
    </div>
    <!--指针变小手-->
    <nav class="nav-two">
      <ul>
        <li><a href="entrance.html">首页</a></li>
        <li><a href="search.html">搜素</a></li>
        <li><a href="detail.html">详情</a></li>
        <li><a href="#">发布艺术品</a></li>
      </ul>
    </nav>
  </header>';
}
function get_html_footer(){
    echo '
        <footer>
	        <p>Produced and miantained by</p>
        </footer>
    </body>
</html>';
}