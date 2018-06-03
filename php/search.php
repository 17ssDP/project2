<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/6/3
 * Time: 19:19
 */
require_once('fns.php');
$db = db_connect();
echo '<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Search Interface</title>
  <link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/search.css">
  <link rel="stylesheet" href="../css/lightbox.css">
  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../js/image-style1.js"></script>
</head>

<body>';
get_html_header("dengpeng");