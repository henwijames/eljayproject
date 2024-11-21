<?php
require_once '../functions/connection.php';
include_once '../functions/get-data.php';
include_once '../functions/administrator/get-data-table.php';
include_once '../functions/get-announcement.php';
include_once '../functions/get-batch.php';
if (session_start() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    header('location: ../index.php');
}
?>
<!DOCTYPE html>
<html data-bs-theme="light" id="bg-animate" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Alumni - Alumni Management System for Yllana Bay View College</title>
    <meta name="twitter:image" content="https://student.lemerycolleges.edu.ph/images/favicon.png">
    <meta name="description" content="Web-Based Alumni Management System for Yllana Bay View College">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/Nunito.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/css/datatables.min.css">
    <link rel="stylesheet" href="../assets/css/Hero-Clean-images.css">
    <link rel="stylesheet" href="../assets/css/Lightbox-Gallery-baguetteBox.min.css">
    <link rel="stylesheet" href="../assets/css/Login-Form-Basic-icons.css">
</head>

<body id="page-top">
<?php
    include_once '../functions/administrator/navbar.php';
    ?>
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <section>
                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-2">Alumni Management</h3>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Alumni List</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Fullname</th>
                                            <th>Course</th>
                                            <th>Major In</th>
                                            <th>Batch</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php get_declined_students(); ?>
                                    </tbody>
                                    <tfoot>
                                        <tr></tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php include_once '../functions/administrator/offcanva-menu.php'; ?>
    <!-- Approve Modal -->
    <div class="modal fade" id="approve" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../functions/administrator/approve_student.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveModalLabel">Approve Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to approve this student?</p>
                        <input type="hidden" name="user_id" id="user_id">
                        <input type="hidden" name="email" id="email">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Yes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" role="dialog" tabindex="-1" id="update">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="../assets/img/navbar.jpg" style="width: 10em;">
                <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" action="../functions/administrator/update-student.php" method="post" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="id">
                    <!-- Username and Password -->
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" name="username" placeholder="Username">
                                <label class="form-label">Student Number : </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="password" name="password" placeholder="Password">
                                <label class="form-label">Password : </label>
                            </div>
                        </div>
                    </div>
                    <!-- Firstname and Lastname -->
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" name="firstname" placeholder="Firstname" >
                                <label class="form-label">Firstname : </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" name="lastname" placeholder="Lastname" >
                                <label class="form-label">Lastname : </label>
                            </div>
                        </div>
                    </div>
                    <!-- Birthdate and Email -->
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input class="form-control" name="birthdate" type="date" >
                                <label class="form-label">Birthdate : </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="email" name="email" placeholder="Email" >
                                <label class="form-label">Email : </label>
                            </div>
                        </div>
                    </div>
                    <!-- Course and Civil Status -->
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="course">
                                    <optgroup label="Course">
                                        <?php get_courses(); ?>
                                    </optgroup>
                                </select>
                                <label class="form-label">Course : </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="civil">
                                    <optgroup label="Status">
                                        <option value="Single" selected>Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widow">Widow</option>
                                    </optgroup>
                                </select>
                                <label class="form-label">Civil Status : </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="tel" name="phone" placeholder="Phone">
                                <label class="form-label">Contact # : </label>
                            </div>
                        </div>
                    </div>
                    <!-- Present Address -->
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" name="present_address" placeholder="Present Address">
                        <label class="form-label">Present Address : </label>
                    </div>
                    <!-- Batch -->
                    <!-- Add this select input for batch in your form -->
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="batch">
                                    <optgroup label="Batch">
                                        <?php get_batches(); ?>
                                    </optgroup>
                                </select>
                                <label class="form-label" for="floatingInput">Batch :&nbsp;</label>
                            </div>
                        </div>
                    </div>
                    <!-- Profile Picture and QR Image -->
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="file" name="profile_pic">
                                <label class="form-label">Profile Picture : </label>
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <button class="btn btn-primary w-100 mb-3" type="submit">Update Student</button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove this alumni?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form action="../functions/administrator/delete-student.php" method="post">
                    <input type="hidden" name="id" id="studentId">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" role="dialog" tabindex="-1" id="approve">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Declined</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to decline this alumni?</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                <form class="needs-validation" action="../functions/administrator/declined-student.php" method="post" method="post" novalidate>
                        <input type="hidden" name="id">
                        <button class="btn btn-primary" type="submit">Declined</button>
                </form>
            </div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="invite">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header"><img src="../assets/img/navbar.jpg" style="width: 10em;"><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <form action="../functions/administrator/get-students.php" method="post">
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" name="start" placeholder="Username" type="date"><label class="form-label" for="floatingInput">Start : </label></div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" name="end" placeholder="Password" type="date"><label class="form-label" for="floatingInput">End : </label></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" type="text" name="title" placeholder="Lastname" required=""><label class="form-label" for="floatingInput">Title :</label></div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" type="text" name="description" placeholder="Lastname" required=""><label class="form-label" for="floatingInput">Description :</label></div>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center mb-4">
                            <button class="btn btn-primary w-100 mb-3" type="submit">Send Invitation</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/datatables.min.js"></script>
    <script src="../assets/js/three.min.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script src="../assets/js/Lightbox-Gallery.js"></script>
    <script src="../assets/js/Lightbox-Gallery-baguetteBox.min.js"></script>
    <script src="../assets/js/sweetalert2.all.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/vanta.fog.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    var approveModal = document.getElementById('approve');
    var updateModal = document.getElementById('update');
    var deleteModal = document.getElementById('delete');

    // Approve modal
    approveModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-user-id');
        var email = button.getAttribute('data-email');

        document.getElementById('user_id').value = userId;
        document.getElementById('email').value = email;
    });

    // Update modal
    updateModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-user-id');
        var username = button.getAttribute('data-username');
        var firstname = button.getAttribute('data-firstname');
        var lastname = button.getAttribute('data-lastname');
        var course = button.getAttribute('data-course');
        var batch = button.getAttribute('data-batch');
        var presentAddress = button.getAttribute('data-present-address');

        document.getElementById('user_id').value = userId;
        document.getElementById('username').value = username;
        document.getElementById('firstname').value = firstname;
        document.getElementById('lastname').value = lastname;
        document.getElementById('course').value = course;
        document.getElementById('batch').value = batch;
        document.getElementById('present_address').value = presentAddress;
    });

    // Delete modal
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-user-id');
        document.getElementById('delete_user_id').value = userId;
    });
});

    </script>
</body>

</html>