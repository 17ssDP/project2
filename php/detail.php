<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/6/3
 * Time: 16:52
 */
require_once("fns.php");
$artworkID = 6;
$db = db_connect();
$query = "select * from artworks where artworkID = '".$artworkID."'";
$stmt = $db->query($query);
while($artwork = $stmt->fetch_assoc()) {
    echo '<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>details</title>
    <link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/detail.css">
    <link rel="stylesheet" href="../css/lightbox.css">
    <link rel="stylesheet" href="../css/jquery-ui.min.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../js/image-style1.js"></script>
    <script type="text/javascript" src="../js/detail.js"></script>
    <script type="text/javascript" src="../js/todo.js"></script>
    <script type="text/javascript">
    </script>
</head> 
<body>';
    get_html_header("dengpeng");
echo'<main>
    <div class="good-details">
        <h2>'.$artwork["title"].'</h2>
        <p>By <a href="search.html" class="author">'.$artwork["artist"].'</a></p>
        <div class="good" id="gallery">
            <a href="../images/images/works/large/001020.jpg"><img src="../images/images/works/average/001020.jpg" alt="good"></a>
        </div>
        <div class="details">
            <p></p>
            <p>price:<span>'.$artwork["price"].'$</span></p>
            <a href="#" class="add-wish"><i class="fa fa-heart-o"></i> Add to Wish list</a>
            <a href="#" class="add-shopping"><i class="fa fa-cart-plus"></i> Add To Shopping Cart</a>
            <table>
                <th colspan="2">Product Details</th>
                <tr>
                    <td>Date:</td>
                    <td>'.$artwork["yearOfWork"].'</td>
                </tr>
                <tr>
                    <td>Medium:</td>
                    <td>Oile on canvas</td>
                </tr>
                <tr>
                    <td>Dimensions:</td>
                    <td>'.$artwork["height"].'cm '.$artwork["width"].'cm</td>
                </tr>
                <tr>
                    <td>Home:</td>
                    <td>Baltimore Art Museum</td>
                </tr>
                <tr>
                    <td>Genres:</td>
                    <td>'.$artwork["genre"].'</td>
                </tr>
                <tr>
                    <td>Subjets:</td>
                    <td>People, Family</td>
                </tr>
                <tr>
                    <td>Heat:</td>
                    <td>'.$artwork["view"].'</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="more-infor">
        <ul class="popular-artist">
            <li>流行艺术家</li>
            <li><a href="#">cnasdio</a></li>
            <li><a href="#">adfagg</a></li>
            <li><a href="#">afgwerfga</a></li>
            <li><a href="#">arggrvf</a></li>
            <li><a href="#">vbcjdtyj</a></li>
            <li><a href="#">ryukj</a></li>
            <li><a href="#">wrunber</a></li>
        </ul>
        <ul class="popular-school">
            <li>流行流派</li>
            <li><a href="#">classic</a></li>
            <li><a href="#">cubuim</a></li>
            <li><a href="#">inpression</a></li>
            <li><a href="#">banrosn</a></li>
            <li><a href="#">nangsu</a></li>
        </ul>
    </div>
</main>
<div id="new-todo" title="添加成功">
</div>
<footer>
</footer>
</body>

</html>';
}
?>


