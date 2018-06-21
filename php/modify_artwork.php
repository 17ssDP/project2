<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/6/16
 * Time: 18:52
 */
require_once('fns.php');
if(!havePermission()){
    require_once("entrance.php");
    exit;
};
if(isset($_GET['id'])) {
    $artworkID = trim($_GET['id']);
}else {
    $artworkID = 6;
}
addFooter('modify_artwork.php?id='.$artworkID.'', '更改艺术品');
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
</head>
<?php get_html_header() ?>
<body>
<main class="container">
    <div class="row">
        <div class="card col-md-6">
            <div class="card-header">
                <h2>艺术品信息</h2>
            </div>
            <div class="card-body">
                <?php
                $db = db_connect();
                $query = "select * from artworks where artworkID = '".$artworkID."'";
                $result = $db->query($query);
                if($result->num_rows == 0) {
                    echo '无法查询艺术品的信息，请稍后再试!';
                }else {
                    while($artwork = $result->fetch_assoc()) {
                        $imageFileName = $artwork['imageFileName'];
                        echo '
                <div class="form-group">
                    <label for="title">艺术品名称:</label>
                    <p id="title_error"></p>
                    <input type="text" class="form-control" id="title" value="'.$artwork['title'].'" data-artworkID="'.$artworkID.'">
                </div>
                <div class="form-group">
                    <label for="artist">作者:</label>
                    <p id="artist_error"></p>
                    <input type="text" class="form-control" id="artist" value="'.$artwork['artist'].'">
                </div>
                <div class="form-group">
                    <label for="description">简介:</label>
                    <p id="description_error"></p>
                    <textarea type="text" class="form-control" id="description">'.$artwork['description'].'</textarea>
                </div>
                <div class="form-group">
                    <label for="yearOfWork">年份:</label>
                    <p id="yearOfWork_error"></p>
                    <input type="text" class="form-control" id="yearOfWork" value="'.$artwork['yearOfWork'].'">
                </div>
                <div class="form-group">
                    <label for="genre">流派:</label>
                    <p id="genre_error"></p>
                    <input type="text" class="form-control" id="genre" value="'.$artwork['genre'].'">
                </div>
                <div class="form-group">
                    <label for="height">长度cm:</label>
                    <p id="height_error"></p>
                    <input type="number" class="form-control" id="height" value="'.$artwork['height'].'">
                </div>
                <div class="form-group">
                    <label for="width">宽度cm:</label>
                    <p id="width_error"></p>
                    <input type="number" class="form-control" id="width" value="'.$artwork['width'].'">
                </div>
                <div class="form-group">
                    <label for="price">价格$:</label>
                    <p id="price_error"></p>
                    <input type="number" class="form-control" id="price" value="'.$artwork['price'].'">
                </div>
                        ';
                    }
                }
                ?>
            </div>
        </div>
        <div class="card col-md-5 offset-md-1">
            <div class="card-header">
                <h2>预览</h2>
            </div>
            <?php
            echo '            
            <div style="height: 500px;" id="showImage">
                <img class="card-img-top" src="../resources/img/'.$imageFileName.'" alt="Card image" style="height: 100%">
            </div>';
            ?>
            <div class="card-body">
                <input type="file" id="image">
                <button type="button" id="release" data-action="modify">点击发布</button>
            </div>
        </div>
    </div>
</main>
<?php getPromptBox() ?>
<script type="text/javascript" src="../js/jquery-3.3.1.js"></script>
<script type="text/javascript" src="../js/fns.js"></script>
<script type="text/javascript" src="../js/modify_artwork.js"></script>
<script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

