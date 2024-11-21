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

// Get batch ID and course from query parameter
$batch_id = isset($_GET['batch']) ? intval($_GET['batch']) : 0;
$selectedCourse = isset($_GET['course']) ? $_GET['course'] : 'all'; // Default to 'all' if no course is selected

// Query to get batch information
$batchStmt = $conn->prepare("SELECT year FROM batch WHERE id = ?");
$batchStmt->bind_param("i", $batch_id);
$batchStmt->execute();
$batchResult = $batchStmt->get_result();


// Modify SQL query to filter students by selected course and active status
$studentsQuery = "
    SELECT s.*, u.username, c.name AS course_name, m.major_name AS major_name, a.name AS achievement_description
    FROM students s
    JOIN users u ON s.user_id = u.id
    JOIN courses c ON s.course = c.id
    LEFT JOIN majors m ON s.major_id = m.id
    LEFT JOIN achievements a ON s.achievement_id = a.id
    WHERE s.batch = ? AND s.status = 'active'
";

if ($selectedCourse === 'all_with_achievements') {
    $studentsQuery .= " AND s.achievement_id IS NOT NULL AND s.achievement_id != ''";
} elseif ($selectedCourse !== 'all') {
    $studentsQuery .= " AND c.name = ?";
}

$studentsQuery .= " ORDER BY c.name, s.lastname ASC";


// Prepare and bind parameters based on the selected course
$studentsStmt = $conn->prepare($studentsQuery);
if ($selectedCourse === 'all') {
    $studentsStmt->bind_param("i", $batch_id);
} elseif ($selectedCourse === 'all_with_achievements') {
    $studentsStmt->bind_param("i", $batch_id); // No need for additional param
} else {
    $studentsStmt->bind_param("is", $batch_id, $selectedCourse);
}
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

// Query to get all available courses for the dropdown, only including active students
$coursesStmt = $conn->prepare("
    SELECT DISTINCT c.id, c.name
    FROM courses c
    JOIN students s ON s.course = c.id
    WHERE s.batch = ? AND s.status = 'active'
");
$coursesStmt->bind_param("i", $batch_id);
$coursesStmt->execute();
$coursesResult = $coursesStmt->get_result();

$coursesList = [];
if ($coursesResult && $coursesResult->num_rows > 0) {
    while ($course = $coursesResult->fetch_assoc()) {
        $coursesList[] = $course;
    }
}
$coursesStmt->close();




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Alumni Management System</title>
    <meta name="twitter:image" content="https://student.lemerycolleges.edu.ph/images/favicon.png">
    <meta name="description" content="Web-Based Alumni Management System">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <title>Yearbook - <?= htmlspecialchars($startYear) ?></title>
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        h1,
        h2 {
            font-family: 'Poppins', sans-serif;
            color: #2c3e50;
        }

        .wrapper {
            padding: 40px 20px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-body {
            padding: 1.5rem;
            text-align: center;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 0.75rem;
            color: #5072A7;
        }

        .card-text {
            color: #5072A7;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .search-bar {
            margin-bottom: 30px;
        }

        .line {
            background-color: #5072A7;
            height: 10px;
        }

        nav.navbar.navbar-expand-md.shadow {
            background-color: #102C57;
        }

        footer {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100%;
        }
    </style>
    <script>
        // Search and filter students by course
        function filterStudents() {
            const searchQuery = document.getElementById('student-search').value.toLowerCase();
            const selectedCourse = document.getElementById('course-filter').value.toLowerCase();
            const courseSections = document.querySelectorAll('.course-section');

            courseSections.forEach(section => {
                const courseName = section.querySelector('h2').textContent.toLowerCase();
                const students = section.querySelectorAll('.card');
                let hasMatchingStudent = false;

                students.forEach(student => {
                    const name = student.querySelector('.card-title').textContent.toLowerCase();
                    const matchesSearch = name.includes(searchQuery);
                    const matchesCourse = selectedCourse === 'all' || courseName === selectedCourse;

                    if (matchesSearch && matchesCourse) {
                        student.parentElement.style.display = ''; // Show student
                        hasMatchingStudent = true;
                    } else {
                        student.parentElement.style.display = 'none'; // Hide student
                    }
                });

                // Hide the entire course section if no student matches
                if (hasMatchingStudent) {
                    section.style.display = ''; // Show course section
                } else {
                    section.style.display = 'none'; // Hide course section
                }
            });
        }

        // Reload the page when a course is selected to apply filtering
        function handleCourseChange() {
            const selectedCourse = document.getElementById('course-filter').value;
            const batchId = <?= $batch_id ?>;
            window.location.href = `?batch=${batchId}&course=${selectedCourse}`;
        }
    </script>
</head>

<body>
    <?php include_once '../functions/student/navbar-menu.php'; ?>
    <div class="wrapper">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <button onclick="window.location.href='gallery.php'" class="btn btn-link">
                        <i class="fas fa-arrow-left" style="font-size: 1.5rem; color:#102C57;"></i>
                    </button>
                    <h1>Yearbook</h1>
                </div>

                <div class=" text-center">

                    <a href="print_all.php?batch=<?= $batch_id ?>" class="btn text-white" style="background-color:#102C57;">Print All Data</a>
                </div>
            </div>
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <?php
                    $sql = "SELECT * FROM courses";
                    $result = mysqli_query($conn, $sql);
                    foreach ($result as $row) {
                        $courseID = $row["id"];
                    ?>
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne<?php echo $courseID ?>" aria-expanded="false" aria-controls="flush-collapseOne">
                                <h5><?= $row["name"] ?></h5>

                            </button>
                        </h2>
                        <div id="flush-collapseOne<?php echo $courseID ?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">

                                <div class="course-section">
                                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4 overflow-y-auto">
                                        <?php
                                        $sqlstu = "SELECT * FROM students WHERE course = '$courseID'";
                                        $resultstu = mysqli_query($conn, $sqlstu);
                                        foreach ($resultstu as $trow) {
                                        ?>
                                            <div class="col">
                                                <div class="card h-100">
                                                    <div
                                                        class="card-img-top"
                                                        style="
                                                        background-image: url('<?= !empty($trow['profile_pic']) ? (preg_match('/data:image/i', $trow['profile_pic']) ? $trow['profile_pic'] : '../student/images/' . $trow['profile_pic']) : 'default-avatar.jpg' ?>');
                                                        background-size: cover;
                                                        background-position: center;
                                                        height: 150px;
                                                    "></div>
                                                    <div class="line"></div>
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?= htmlspecialchars($trow['lastname']) ?>, <?= htmlspecialchars($trow['firstname']) ?></h5>
                                                        <p class="card-text"><em><?= htmlspecialchars($trow['present_address']) ?></em></p>
                                                        <p class="card-text"><em><?= htmlspecialchars($trow['birthdate']) ?></em></p>
                                                        <p class="card-text">
                                                            <em>
                                                                <?php
                                                                if (isset($trow['motto'])) {
                                                                    echo '"' . htmlspecialchars($trow['motto']) . '"';
                                                                } else {
                                                                    echo "No Motto Inserted";
                                                                }
                                                                ?>
                                                            </em>
                                                        </p>
                                                        <p class="card-text">
                                                            <?php $major = $trow['major_id'];
                                                            $msql = "SELECT * FROM majors WHERE id = '$major'";
                                                            $mres = mysqli_query($conn, $msql);
                                                            $mrow = mysqli_fetch_assoc($mres);
                                                            echo @$mrow['major_name'];

                                                            ?>
                                                        </p>
                                                        <p class="card-text text-success">
                                                            <i class="fas fa-trophy"></i>
                                                            <?php $ach = $trow['achievement_id'];
                                                            $achsql = "SELECT * FROM achievements WHERE id = '$ach'";
                                                            $achres = mysqli_query($conn, $achsql);
                                                            $acrow = mysqli_fetch_assoc($achres);
                                                            echo @$acrow["name"];
                                                            ?>
                                                        </p>


                                                    </div>

                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }

                    ?>




                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="sign-out">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Sign out</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to sign out?</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                    <a class="btn btn-danger" type="button" href="../functions/logout.php">Sign out</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Reload the page when a course is selected to apply filtering
        function handleCourseChange() {
            const selectedCourse = document.getElementById('course-filter').value;
            const batchId = <?= $batch_id ?>;
            window.location.href = `?batch=${batchId}&course=${selectedCourse}`;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>
<?php
mysqli_close($conn);
?>