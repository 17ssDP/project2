<!DOCTYPE html>
<html>
<head>
    <title>尝试连接数据库</title>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/5/24
 * Time: 20:37
 */
require_once("fns.php");
//获取查询信息
$search = trim($_POST['search']);
$name = "Pablo Picasso";
//连接数据库
$db = db_connect("artworks");
//查询数据库
$query = "SELECT artworkID, title, price FROM artworks WHERE artist = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('s',$name);
$stmt->execute();
$stmt->store_result();
//读取查询结果
$stmt->bind_result($id,$title, $price);
echo "<p>Number of works found: ".$stmt->num_rows."</p>";
while($stmt->fetch()) {
    echo "<p>artistID: ".$id."</p>";
    echo "<p>Title: 《".$title."》</p>";
    echo "<p>Price: ".$price."$</p>";
}
//释放结果集
$stmt->free_result();
//关闭数据库连接
$db->close();
?>
</body>
</html>
