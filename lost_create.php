<?php

if (
  !isset($_POST['from_place	']) || $_POST['from_place	'] == '' ||
    !isset($_POST['to_place	']) || $_POST['to_place	'] == '' ||
  !isset($_POST['deadline']) || $_POST['deadline'] == ''
) {
  exit('paramError');
}

$from_place	 = $_POST['from_place	'];
$to_place	 = $_POST['to_place	'];
$deadline = $_POST['deadline'];

// DB接続
$dbn='mysql:dbname=y_dev01_08;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

$sql = 'INSERT INTO lost_table(id, from_place, to_place, deadline, created_at, updated_at, departure, arrival) VALUES(NULL, :todo, :deadline, now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':from_place	', $from_place	, PDO::PARAM_STR);
$stmt->bindValue(':from_place	', $to_place	, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:lost_input.php");
exit();
