<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Search Interface</title>
  <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/head.css">
  <link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/search.css">
  <link rel="stylesheet" href="../css/lightbox.css">
  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../js/image-style1.js"></script>
</head>

<body>
<header class="container-fluid">
    <nav class="nav-one row">
        <ul class="nav offset-md-9 row">
            <li class="nav-item"><a class="nav-link" href="personal.php"><i class="fa fa-user"></i> chenk</a></li>
            <li class="nav-item"><a class="nav-link" href="Shopping-cart.html"><i class="fa fa-shopping-cart"></i> 购物车</a></li>
            <li class="nav-item"><a class="nav-link" href="entrance.html"><i class="fa fa-sign-out"></i> 登出</a></li>
        </ul>
    </nav>
    <div class="row">
        <h1 class="col-md-8">Art Store</h1>
        <div class="search-box form-group col-md-4">
            <input class="col-md-8 searchImage" type="text" name="" value=""><input class="col-md-4" type="submit" name="" value="搜索" onclick="javascript:window.location.href=\'search.html\'">
        </div>
    </div>
    <!--指针变小手-->
    <nav class="nav-two row">
        <ul class="nav">
            <li class="nav-item"><a class="nav-link" href="entrance.html">首页</a></li>
            <li class="nav-item"><a class="nav-link" href="search.html">搜素</a></li>
            <li class="nav-item"><a class="nav-link" href="detail.html">详情</a></li>
            <li class="nav-item"><a class="nav-link" href="#">发布艺术品</a></li>
        </ul>
    </nav>
</header>
  <main class="container-fluid">
    <h2 class="row">搜索结果:</h2>
    <div class="sort-way col-md-3 offset-md-9">
      <h3>排序方式:</h3>
      <p>价格:<input type="radio" name="sort" value=""> 热度:
        <input type="radio" name="sort" value=""> 标题:
        <input type="radio" name="sort" value=""></p>
    </div>
  </main>
  <div id="gallery" class="search-result">';
      <?php
      require_once('fns.php');
      $db = db_connect();
      $query = "select * from artworks";
      $result = $db->query($query);
      if($result) {
          $totalCount = $result->num_rows;
      } else{
          $totalCount = 0;
      }
      if($totalCount == 0) {
          echo 'no artworks';
      } else {
      $pageSize = 9;
      $totalPage = (int)(($totalCount%$pageSize == 0)? ($totalCount/$pageSize) : ($totalCount/$pageSize+1));
      if(!isset($_GET['page'])) {
          $currentPage = 1;
      }
      else {
          $currentPage = $_GET['page'];
      }
      $mark = ($currentPage-1)*$pageSize;
      $firstPage = 1;
      $lastPage = $totalPage;
      $prePage = ($currentPage>1)?$currentPage-1:1;
      $nextPage = ($totalPage-$currentPage>0)?$currentPage+1:$totalPage;
      $query = "select * from artworks limit " . $mark . "," . $pageSize."";
      $result = $db->query($query);
      while ($row = $result->fetch_assoc()) {
        echo'<div class="img-infor">
          <div class="img-name">
              <img src="../resources/img/'.$row["imageFileName"].'">
              <p>'.$row['title'].'</p>
          </div>
          <div class="introduce">
              <p>'.$row['artist'].'</p>
          </div>
          <div class="img-button">
              <input type="button" name="" value="查看" onclick="javascript:window.location.href=\'detail.html\'">
              <input type="button" name="" value="热度">
          </div>
          </div>';
      }
      }
      ?>
  </div>
  <footer class="container">
    <ul class="pagination pagination-lg">
<!--      <li class="page-item"><a class="page-link" href="#"><i class="fa fa-chevron-left"></i></a></li>-->
<!--      <li class="page-item"><a class="page-link" href="#">1</a></li>-->
<!--      <li class="page-item"><a class="page-link"href="#">2</a></li>-->
<!--      <li class="page-item"><a class="page-link" href="#">3</a></li>-->
<!--      <li class="page-item"><a class="page-link" href="#">4</a></li>-->
<!--      <li class="page-item"><a class="page-link" href="#">5</a></li>-->
<!--      <li class="page-item"><a class="page-link" href="#">6</a></li>-->
<!--      <li class="page-item"><a class="page-link" href="#">7</a></li>-->
<!--      <li class="page-item"><a class="page-link" href="#">8</a></li>-->
<!--      <li class="page-item"><a class="page-link" href="#">9</a></li>-->
<!--      <li class="page-item"><a class="page-link" href="#">10</a></li>-->
<!--      <li class="page-item"><a class="page-link" href="#"><i class="fa fa-chevron-right"></i></a></li>-->
        <li class="page-item"><a class="page-link" href="try-search.php?page=<?php echo $firstPage; ?>">FirstPage</a></li>&nbsp;&nbsp;
        <li class="page-item"><a class="page-link" href="try-search.php?page=<?php echo $prePage; ?>">PrePage</a></li>&nbsp;
        <li class="page-item"><a class="page-link" href="try-search.php?page=<?php echo $nextPage; ?>">NextPage</a></li>&nbsp;&nbsp;
        <li class="page-item"><a class="page-link" href="try-search.php?page=<?php echo $lastPage; ?>">LastPage</a></li>
    </ul>
  </footer>
  <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</body>

</html>