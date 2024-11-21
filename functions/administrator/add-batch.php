<?php
require_once '../connection.php';
$year = $_POST['year'];

$sql = 'INSERT INTO `batch` (`year`) VALUES (:year)';
$stmt = $db->prepare($sql);
$stmt->bindParam(':year', $year);
$stmt->execute();
header('Location: ../../administrator/batch.php?type=success&message=Successfully Added');

