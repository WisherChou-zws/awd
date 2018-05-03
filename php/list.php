<?php
// header("Content-type:text/html;charset=utf-8");
$servername = "127.0.0.1";
$username = "zws";
$password = "123456";
// 创建连接
$conn = mysqli_connect($servername, $username, $password,'practice');
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
mysqli_query($conn, "SET NAMES utf8");
$query = mysqli_query($conn, "SELECT * FROM list");
//header('Content-Type:application/json');
if (mysqli_num_rows($query) > 0) {
  // 输出数据
  $list = array();
  while($row = mysqli_fetch_array($query)) {
    $data['id'] = $row["id"];
    $data['title'] = $row["title"];
    $data['shortcontent'] = $row["shortcontent"];
    array_push($list,$data);
    // $list = $data;
  }
  $row['row'] = $list;
  // $row['count'] = count($list);
  echo json_encode($row,JSON_UNESCAPED_UNICODE);
} else {
  echo "0 结果";
}



mysqli_close($conn);
?>
