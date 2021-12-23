<?php
//var_dump($_POST);
//exit();
// 入力項目のチェック


// DB接続


// SQL実行


if (
  !isset($_POST['from_place	']) || $_POST['from_place	'] == '' ||
    !isset($_POST['to_place	']) || $_POST['to_place	'] == '' ||
  !isset($_POST['deadline']) || $_POST['deadline'] == ''
) {
  exit('paramError');
}

$from_place = $_POST['from_place'];
$to_place = $_POST['to_place'];
$deadline = $_POST['deadline'];
$id = $_POST['id'];

// DB接続

include('functions.php');
$pdo = connect_to_db();

$sql = 'UPDATE lost_table SET from_place=:from_place, to_place, deadline=:deadline, updated_at=now() WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':from_place', $from_place, PDO::PARAM_STR);
$stmt->bindValue(':to_place', $to_place, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header('Location:lost_read.php');
exit();
