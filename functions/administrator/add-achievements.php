<?php
require_once '../connection.php';
$name = $_POST['name'];

$sql = 'INSERT INTO `achievements` (`name`) VALUES (:name)';
$stmt = $db->prepare($sql);
$stmt->bindParam(':name', $name);
$stmt->execute();
header('Location: ../../administrator/batch.php?type=success&message=Successfully Added');

