<?php
function get_Batches(){
    global $db;
    $sql = "SELECT * FROM `batch`";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        echo '<option value="' . $row['id'] . '">' . $row['year'] . '</option>';
    }
}
