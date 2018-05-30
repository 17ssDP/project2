<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Personal Information</title>
  <link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/personal.css">
  <link rel="stylesheet" href="../css/jquery-ui.min.css">
  <!-- <script type="text/javascript" src="../js/jquery-3.3.1.js"></script> -->
  <script type="text/javascript" src="../js/personal.js"></script>
  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="../js/image-style1.js"></script>
  <script type="text/javascript" src="../js/personal.js"></script>
</head>
<body>
<?php require_once("../try/html_header.php") ?>
  <main>
    <div class="information">
      <table>
        <tr>
          <td>用户：</td>
          <td>17302010026</td>
        </tr>
        <tr>
          <td>电话：</td>
          <td></td>
        </tr>
        <tr>
          <td>邮箱：</td>
          <td></td>
        </tr>
        <tr>
          <td>地址：</td>
          <td></td>
        </tr>
        <tr>
          <td>余额：</td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"><input id="recharge" type="button" name="" value="充值信仰"></td>
        </tr>
      </table>
    </div>
    <div class="record">
      <div class="upload">
        <h2>我上传的艺术品:</h2>
      </div>
      <div class="buy">
        <h2>我购买的艺术品：</h2>
        <table>
          <tr>
            <td>订单编号：20160526060</td>
            <td>商品名称：Sunflowers</td>
            <td>订单时间：2016.05.26</td>
            <td>订单金额：$400</td>
          </tr>
          <tr>
            <td>订单编号：20160526060</td>
            <td>商品名称：Sunflowers</td>
            <td>订单时间：2016.05.26</td>
            <td>订单金额：$100</td>
          </tr>
        </table>
      </div>
      <div class="sell">
        <h2>我卖出的艺术品：</h2>
      </div>
    </div>
  </main>
  <div id="new-todo" title="充值成功">
  </div>
</body>

</html>