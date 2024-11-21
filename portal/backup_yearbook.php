<?php
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "lc");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get batch ID from query parameter
$batch_id = isset($_GET['batch']) ? intval($_GET['batch']) : 0;

// Query to get batch information
$batchStmt = $conn->prepare("SELECT year FROM batch WHERE id = ?");
$batchStmt->bind_param("i", $batch_id);
$batchStmt->execute();
$batchResult = $batchStmt->get_result();

if ($batchResult && $batchResult->num_rows > 0) {
    $batch = $batchResult->fetch_assoc();
    $startYear = $batch['year'];
} else {
    $startYear = 'Not Available';
}

// Query to get students in the selected batch who are approved
$studentsStmt = $conn->prepare("
    SELECT s.*, u.username, c.name AS course_name, m.major_name AS major_name
    FROM students s
    JOIN users u ON s.user_id = u.id
    JOIN courses c ON s.course = c.id
    LEFT JOIN majors m ON s.major_id = m.id
    WHERE s.batch = ? AND u.status = 'approved'
    ORDER BY c.name, s.lastname ASC
");

$studentsStmt->bind_param("i", $batch_id);
$studentsStmt->execute();
$studentsResult = $studentsStmt->get_result();

$studentsByCourse = []; // Initialize the array
if ($studentsResult && $studentsResult->num_rows > 0) {
    while ($row = $studentsResult->fetch_assoc()) {
        // Group students by course name
        $studentsByCourse[$row['course_name']][] = $row;
    }
}

$studentsStmt->close();
$batchStmt->close();
mysqli_close($conn);

// Pagination for courses
$coursesPerPage = 1; // Number of courses per page
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1; // Get the current page number
$totalCourses = count($studentsByCourse);
$totalPages = ceil($totalCourses / $coursesPerPage);

// Slice courses for current page
$courseKeys = array_keys($studentsByCourse);
$currentCourses = array_slice($courseKeys, ($currentPage - 1) * $coursesPerPage, $coursesPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Yearbook - <?= htmlspecialchars($startYear) ?></title>
    <style>
        /* Custom Card Styles */
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 1.5rem;
            text-align: center;
        }
        .card-title {
            margin-bottom: 0.5rem;
            font-size: 1.25rem;
            font-weight: bold;
        }
        .card-text {
            color: #555;
            margin-bottom: 0.25rem;
        }
        .wrapper {
            padding: 20px;
        }
        /* Custom Print Button */
        .print-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 0.75rem 1rem;
            cursor: pointer;
        }
        .print-btn:hover {
            background-color: #0056b3;
        }
        /* Print Styles */
        @media print {
            /* Add specific styles for print view */
            body {
                margin: 0;
                padding: 0;
            }
            .wrapper {
                padding: 0;
            }
            .card {
                width: auto;
                height: auto;
                border: 1px solid #000;
                padding: 10px;
                background-color: #fff;
                box-sizing: border-box;
                page-break-inside: avoid;
            }
            .course-section {
                page-break-before: always; /* Start each course on a new page */
            }
        }
    </style>
    <script>
        function printYearbook() {
            window.print();
        }
    </script>
</head>
<body>
<div class="wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <button onclick="window.location.href='home.php'" class="btn btn-link text-primary">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h1>Yearbook for Batch (<?= htmlspecialchars($startYear) ?>)</h1>
        <!-- <button class="btn btn-primary" onclick="printYearbook()">Print Yearbook</button> -->
        <div class="mt-4 text-center">
        <a href="print_all.php?batch=<?= $batch_id ?>" class="btn btn-secondary">Print All Data</a>
        </div>
    </div>

    <?php foreach ($currentCourses as $courseName): ?>
        <div class="course-section">
            <h2 class="mt-4"><?= htmlspecialchars($courseName) ?></h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
                <?php foreach ($studentsByCourse[$courseName] as $student): ?>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-img-top img-fluid" style="background-image: url('<?= !empty($student['profile_pic']) ? (preg_match('/data:image/i', $student['profile_pic']) ? $student['profile_pic'] : '../student/images/'.$student['profile_pic']) : 'default-avatar.jpg' ?>'); background-size: cover; background-position: center; height: 250px;"></div>
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= htmlspecialchars($student['lastname'] . ' ' . $student['firstname']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($student['major_name']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Pagination Controls -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($currentPage > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?batch=<?= $batch_id ?>&page=<?= $currentPage - 1 ?>">Previous</a>
                </li>
            <?php endif; ?>
            <li class="page-item active">
                <span class="page-link"><?= $currentPage ?></span>
            </li>
            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?batch=<?= $batch_id ?>&page=<?= $currentPage + 1 ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Print All Data Button -->
    
</div>
</body>
</html>
