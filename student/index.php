<?php
if (session_start() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header('location: administrator/index.php');
    exit;
}

try {
    // Database connection
    $pdo = new PDO('mysql:host=localhost;dbname=lc', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch user data from the students table
    $stmt = $pdo->prepare("
        SELECT s.firstname, s.lastname, s.email, s.phone, s.profile_pic, s.present_address, s.work, s.company ,s.qrimage
        FROM students s
        JOIN users u ON s.user_id = u.id
        WHERE u.username = :username
    ");
    $stmt->execute(['username' => $_SESSION['username']]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if student data was found
    if (!$student) {
        throw new Exception('User not found.');
    }
} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
    exit;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html data-bs-theme="light" id="bg-animate" lang="en">

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
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/Nunito.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/css/animate.min.css">
    <link rel="stylesheet" href="../assets/css/datatables.min.css">
    <link rel="stylesheet" href="../assets/css/Hero-Clean-images.css">
    <link rel="stylesheet" href="../assets/css/Lightbox-Gallery-baguetteBox.min.css">
    <link rel="stylesheet" href="../assets/css/Login-Form-Basic-icons.css">
</head>
<style>
body {
    background-color: white;
    background-size: cover; /* Ensure the background covers the viewport */
    background-position: center; /* Center the background image */
    background-repeat: no-repeat; /* Prevent background repetition */
    margin: 0; /* Remove default margin */
    height: 100vh; /* Full height of the viewport */
    display: flex; /* Flexbox for centering */
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
    position: relative; /* Relative positioning for overlay and card */
}

.overlay {
    position: absolute; /* Cover the entire background */
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}



@media (max-width: 768px) {
    .container {
        width: 90%; /* Full width on smaller screens */
    }
}

nav.navbar.navbar-expand-md.shadow {
    background-color: #102C57;
}
    input.form-control{
    background: #171717;
    padding: 1.5em 20px;
    width: 100%;
    border: 0;
    outline: 0;
    background: transparent;
    border-bottom: 2px solid #d3d3d3;
    color: #000;
    margin: 10px 0;
    line-height: 14px;
}

textarea.form-control{
    background: #171717;
    padding: 1.5em 20px;
    width: 100%;
    border: 0;
    outline: 0;
    background: transparent;
    border-bottom: 2px solid #d3d3d3;
    color: #000;
    margin: 10px 0;
    line-height: 14px;
}

input.form-control:focus {
    border-bottom: 2px solid #007bff; /* Underline color on focus */
    box-shadow: none;
    outline: none;
}

button.btn.btn-primary.form-control {
    color: #fff;
    background-color: #000;
    border-color: #000;
}

button.btn.btn-primary.form-control:hover {
    color: #000;
    background-color: #fff;
}
</style>
<body id="page-top">
<div class="overlay">
    <?php include_once '../functions/student/navbar-menu.php'; ?>

    <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
            <section id="contact" class="py-4 py-xl-5">
    <div class="container-fluid"> <!-- Changed to container-fluid -->
        <div class="row">
           

            <!-- Right Column: Form -->
            <div class="col-md-12">
                    <form action="update-profile.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($student['firstname'] ?? ''); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($student['lastname'] ?? ''); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($student['email'] ?? ''); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($student['phone'] ?? ''); ?>" required>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="work">Work</label>
                                    <input type="text" class="form-control" id="work" name="work" value="<?php echo htmlspecialchars($student['work'] ?? ''); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="company">Company Name</label>
                                    <input type="text" class="form-control" id="company" name="company" value="<?php echo htmlspecialchars($student['company'] ?? ''); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="present_address">Address</label>
                                    <input type="text" class="form-control" id="present_address" name="present_address" value="<?php echo htmlspecialchars($student['present_address'] ?? ''); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="profile_pic">Profile Picture</label>
                                    <input type="file" class="form-control-file" id="profile_pic" name="profile_pic">
                                    <?php if (!empty($student['profile_pic'])): ?>
                                        <img src="images/<?php echo htmlspecialchars($student['profile_pic']); ?>" alt="Profile Picture" style="width: 100px; height: 100px;">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Download Image
                </button>
                    </form>

                    </div>
                </div>
            </section>
    </div>
        </div>
    </div>

    <!-- Modal for Instructions -->
<div class="modal fade" id="instructionsModal" tabindex="-1" aria-labelledby="instructionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="instructionsModalLabel">Instructions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h2>Instructions</h2>
                <p>Please follow the instructions below:</p>
                <div class="instructions-template">
                    <h3>Step 1: Update</h3>
                    <ul>
                        <li>Update your information.</li>
                        <li>Double check.</li>
                    </ul>
                    
                    <h3>Step 2: Generate</h3>
                    <ul>
                        <li>Click Generate QR.</li>
                        <li>Download QR and save.</li>
                    </ul>
                    
                    <h3>Step 3: Portal</h3>
                    <ul>
                        <li>Go to Portal site.</li>
                        <li>Scan your qrcode.</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                    <a class="btn btn-danger" type="button" href="../functions/logout.php">Sign out</a></div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Download Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="<?= preg_match('/data:image/i', $student['qrimage']) ? $student['qrimage'] : '../functions/student/qrcodes/'.$student['qrimage'] ?>" alt="Student Profile" class="img-fluid">
                <p class="mt-3">Click the button below to download the image.</p>
                <a href="<?= preg_match('/data:image/i', $student['qrimage']) ? $student['qrimage'] : '../functions/student/qrcodes/'.$student['qrimage'] ?>" download="student-image.jpg" class="btn btn-primary">Download QR</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    </div>
    </div>
    


    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/bs-init.js"></script>
    <script src="../assets/js/datatables.min.js"></script>
    <script src="../assets/js/Lightbox-Gallery-baguetteBox.min.js"></script>
</body>
</html>
