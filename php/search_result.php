<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/6/10
 * Time: 9:36
 */
header('content="text/html;charset=utf-8"');
require_once('fns.php');
$db = db_connect();
$searchImage = trim($_POST['searchImage']);
$sortWay = trim($_POST['sortWay']);
$currentPage = trim($_POST['currentPage']);
$pageSize = trim($_POST['pageSize']);
$mark = $mark = ($currentPage - 1) * $pageSize;
//$query = "select * from artworks";
//$query = "select * from artworks ORDER BY ".$sortWay." limit " . $mark . "," . $pageSize. "";
$queryAll = "select * from artworks where (artist like '%$searchImage%') or (title like '%$searchImage%') or (description like '%$searchImage%')";
$queryPage = "SELECT * FROM artworks WHERE (artist like '%$searchImage%') or (title like '%$searchImage%') or (description like '%$searchImage%') ORDER BY ".$sortWay." limit " . $mark . "," . $pageSize. "";
$result = $db->query($queryAll);
if($result) {
    $totalCount = $result->num_rows;
    $totalPage = (int)(($totalCount % $pageSize == 0) ? ($totalCount / $pageSize) : ($totalCount / $pageSize + 1));
}else {
  $totalPage = 0;
}
$result = $db->query($queryPage);
$html = '';
while ($row = $result->fetch_assoc()) {
    $html .= '<div class="img-infor">
                    <div class="img-name">
                        <img src="../resources/img/'.$row["imageFileName"].'">
                         <p>'.$row['title'].'</p>
                    </div>
                    <div class="introduce">
                        <p>'.$row['artist'].'</p>
                    </div>
                    <div class="img-button">
                        <input type="button" name="" value="查看" onclick="javascript:window.location.href=\'../php/detail.php?id='.$row['artworkID'].'\'">
                        <input type="button" name="" value="热度">
                    </div>
              </div>
    ';
}
echo json_encode(['html'=>$html, 'totalPage'=>$totalPage]);

