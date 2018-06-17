<?php
require_once('fns.php');
addFooter('search.php', '搜索');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Search Interface</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/head.css">
    <link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/search.css">
    <link rel="stylesheet" href="../css/land.css">
<!--    <link rel="stylesheet" href="../css/lightbox.css">-->
    <script type="text/javascript" src="../js/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../js/image-style1.js"></script>
    <script type="text/javascript" src="../js/fns.js"></script>
    <script type="text/javascript" src="../js/search.js"></script>
</head>

<body>
<?php get_html_header() ?>
<main class="container-fluid">
    <h2 class="row offset-md-1">搜索结果:</h2>
    <div class="sort-way col-md-4 offset-md-8 row">
        <h5 class="col-md-3">排序方式:</h5>
        <form id="sortWay">价格:<input type="radio" name="sort" value="price" checked = "checked"> 热度:
            <input type="radio" name="sort" value="view"> 标题:
            <input type="radio" name="sort" value="title"></form>
    </div>
</main>
<div id="gallery" class="search-result">
</div>
<footer class="container">
    <ul class="pagination pagination-lg">
        <li class="page-item"><a class="page-link firstPage">第一页</a></li>
        <li class="page-item"><a class="page-link prePage">上一页</a></li>
        <li class="page-item"><a class="page-link nextPage">下一页</a></li>
        <li class="page-item"><a class="page-link lastPage">尾页</a></li>
        <li class="page-item"><form class="page-link"><label>第</label><input class="jump" type="number" style="width: 50px; height: 30px">页</form></li>
        <li class="page-item"><p class="page-link totalPage"></p></li>
    </ul>
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