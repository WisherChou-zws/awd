<?php
header('Access-Control-Allow-Origin:*');
date_default_timezone_set("Asia/Shanghai");
$data['msg'] = '';
$data['status'] = 0;

$name = $_POST['name'];
$password = $_POST['password'];
$phone = $_POST['phone'];
$avatar = $_POST['avatar'];
$sex = $_POST['sex'];

// if(!$name || !$password || !$phone || !$avatar || !$sex) {
//   $data['msg'] = '参数不全';
//   echo json_encode($data);
//   exit;
// }
if (empty($name)) {
  $data['msg'] = '请填写名称';
  echo json_encode($data);
  exit;
}
if (empty($password)) {
  $data['msg'] = '请填写密码';
  echo json_encode($data);
  exit;
} else if (strlen($phone) < 6) {
  $data['msg'] = '密码至少需要6个字符';
  echo json_encode($data);
  exit;
}
if (empty($phone)) {
  $data['msg'] = '请填写手机号';
  echo json_encode($data);
  exit;
} else if (strlen($phone) != 11 && !preg_match( '/^1[3|4|5|8][0-9]\d{4,8}$/', $phone)) {
  $data['msg'] = '手机号码格式错误';
  echo json_encode($data);
  exit;
}
if ($sex != '0' && $sex != '1') {
  $data['msg'] = '请选择性别';
  echo json_encode($data);
  exit;
}

// 创建连接
$conn = mysqli_connect('127.0.0.1', 'zws', '123456','practice');
// 检测连接
if (mysqli_connect_error()) {
    die("连接失败: " . mysqli_connect_error());
}
mysqli_query($conn, "SET NAMES utf8");

$query = mysqli_query($conn, "SELECT * FROM user where name='".$name."'");
if (mysqli_num_rows($query) > 0) {
  $data['msg'] = '该名称已存在';
  echo json_encode($data);
  exit;
}
else {
  $length = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user")) + 1;
  $query = 'insert into user (id, name, password, phone, avatar, sex, register_time) values('.$length.',"'.$name.'","'.$password.'",'.$phone.',"'.$avatar.'",'.$sex.',"'.date("Y-m-d h:i:s",time()).'")';
  $insert = mysqli_query($conn, $query);
  mysqli_close($conn);
  if ($insert) {
    $data['msg'] = '注册成功';
    $data['status'] = 1;
    echo json_encode($data);
    exit;
  } else {
    $data['msg'] = '注册失败';
    echo json_encode($data);
    exit;
  }
}



?>
