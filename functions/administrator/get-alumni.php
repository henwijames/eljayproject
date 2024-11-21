<?php
$sql = "
SELECT 
  c.id AS course_id, 
  c.name AS course_name, 
  b.id AS batch_id,
  b.year AS batch_year,
  CONCAT(s.firstname, ' ', s.lastname) AS student_name
FROM 
  courses c
JOIN 
  students s ON c.id = s.course
JOIN
  batch b ON s.batch = b.id
GROUP BY 
  c.id, b.id
ORDER BY 
  c.id, b.id;
";

$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $row) {
  $courseName = htmlspecialchars($row['course_name']);
  $batchYear = htmlspecialchars($row['batch_year']);
  $batchId = htmlspecialchars($row['batch_id']);
  echo '<div class="col">';
  echo '<div class="card">';
  echo '<div class="card-body shadow-sm">';
  echo '<h3 class="text-center card-title">' . $courseName . ' (' . $batchYear . ')' . '</h3>';
  echo '<div class="table-responsive">';
  echo '<table class="table display table-hover table-sm">';
  echo '<thead>';
  echo '<tr>';
  echo '<th>Fullname</th>';
  echo '<th>Course</th>';
  echo '<th>Batch ID</th>';
  echo '<th>Year Graduated</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';

  $sql2 = "
  SELECT 
    CONCAT(s.firstname, ' ', s.lastname) AS student_name
  FROM 
    students s
  JOIN 
    users u ON s.user_id = u.id
  WHERE 
    s.course = :course_id
  AND 
    s.batch = :batch_id
  AND 
    u.status = 'approved'
  ORDER BY 
    student_name ASC";

  $stmt2 = $db->prepare($sql2);
  $stmt2->bindValue(':course_id', $row['course_id']);
  $stmt2->bindValue(':batch_id', $row['batch_id']);
  $stmt2->execute();
  $students = $stmt2->fetchAll(PDO::FETCH_ASSOC);

  foreach ($students as $student) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($student['student_name']) . '</td>';
    echo '<td>' . $courseName . '</td>';
    echo '<td>' . $batchId . '</td>';
    echo '<td>' . $batchYear . '</td>';
    echo '</tr>';
  }

  echo '</tbody>';
  echo '</table>';
  echo '</div>';
  echo '</div>';
  echo '</div>';
  echo '</div>';
}
?>
