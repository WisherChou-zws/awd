<?php

$servername = "127.0.0.1";
$username = "zws";
$password = "123456";
// 创建连接
$conn = mysqli_connect($servername, $username, $password,'practice');
// 检测连接
if (mysqli_connect_error()) {
    die("连接失败: " . mysqli_connect_error());
}
mysqli_query($conn, "SET NAMES utf8");

$name = $_POST['name'];
$password = $_POST['password'];
$data = [];
$row = [];
$data['name'] = $name;
$data['password'] = $password;
// $row['row'] = $data;
// echo json_encode($row);

$query = mysqli_query($conn, "SELECT * FROM user where name='".$name."'");
//header('Content-Type:application/json');
if (mysqli_num_rows($query) > 0) {
  // 输出数据
  $result = [];
  while($row = mysqli_fetch_array($query)) {
    if ($row['password'] == $data['password']) {
      setcookie('user_id',$row['id']);
      setcookie('user_name',$name);
      $result['msg'] = '登陆成功';
      $result['status'] = 1;
      echo json_encode($result);
    }
    else {
      $result['msg'] = '密码错误';
      $result['status'] = 0;
      echo json_encode($result);
    }
  }
}
else {
  $result['msg'] = '账号不存在';
  $result['status'] = 0;
  echo json_encode($result);
}







mysqli_close($conn);
?>
