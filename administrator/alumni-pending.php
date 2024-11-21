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
    <title>Alumni - Alumni Management System</title>
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
    <link rel="stylesheet" href="../assets/css/datatables.min.css">
    <link rel="stylesheet" href="../assets/css/Hero-Clean-images.css">
    <link rel="stylesheet" href="../assets/css/Lightbox-Gallery-baguetteBox.min.css">
    <link rel="stylesheet" href="../assets/css/Login-Form-Basic-icons.css">
</head>
<style>
img#view-file-pic {
    height: auto;
    width: auto;
}

</style>
<body id="page-top">
<?php
    include_once '../functions/administrator/navbar.php';
    ?>
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <section>
                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-2">Alumni Pending Management</h3>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Alumni Pending List</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                                <table class="table display my-0" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Fullname</th>
                                        <th>Course</th>
                                        <th>Batch</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php get_students_pending(); ?>
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
    <div class="modal fade" role="dialog" tabindex="-1" id="add">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header"><img src="../assets/img/navbar.jpg" style="width: 10em;"><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <form class="needs-validation" action="../functions/administrator/add-student.php" method="post" novalidate>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" type="text" name="username" placeholder="Username" required><label class="form-label" for="floatingInput">Username : </label></div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" type="password" name="password" placeholder="Password" required><label class="form-label" for="floatingInput">Password : </label></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" type="text" name="firstname" placeholder="Firstname" required><label class="form-label" for="floatingInput">Firstname : </label></div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" type="text" name="lastname" placeholder="Lastname" required><label class="form-label" for="floatingInput">Lastname : </label></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" name="birthdate" type="date" required><label class="form-label" for="floatingInput">Birthdate : </label></div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" type="email" name="email" placeholder="Email" required><label class="form-label" for="floatingInput">Email : </label></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3"><select class="form-select" required name="course">
                                        <optgroup label="Course">
                                            <?php get_courses(); ?>
                                        </optgroup>
                                    </select><label class="form-label" for="floatingInput">Course :&nbsp;</label></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3"><select class="form-select" required name="civil">
                                        <optgroup label="Status">
                                            <option value="Single" selected="">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Widow">Widow</option>
                                        </optgroup>
                                    </select><label class="form-label" for="floatingInput">Civil Status : </label></div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" type="date" name="graduated" placeholder="graudate" required><label class="form-label" for="floatingInput">Graduated at: </label></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" type="tel" name="phone" placeholder="phone" required><label class="form-label" for="floatingInput">Contact #: </label></div>
                            </div>
                        </div>
                        <div class="form-floating mb-3"><input class="form-control form-control" type="text" name="present_address" placeholder="Present Address" required><label class="form-label" for="floatingInput">Present Address : </label></div>
                        <button class="btn btn-primary w-100 mb-3" type="submit">Add Student</button>
                        <div class="d-flex flex-column align-items-center mb-4"></div>
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>
    <!-- View Modal -->
    <div class="modal fade" role="dialog" tabindex="-1" id="view">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
                <img id="view-file-pic" src="" alt="File Picture" width="100" height="100">
        </div>
    </div>
</div>

    <div class="modal fade" role="dialog" tabindex="-1" id="add">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header"><img src="../assets/img/navbar.jpg" style="width: 10em;"><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <form class="needs-validation" action="../functions/administrator/add-student.php" method="post" novalidate>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" type="text" name="username" placeholder="Username" required><label class="form-label" for="floatingInput">Student Number : </label></div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" type="password" name="password" placeholder="Password" required><label class="form-label" for="floatingInput">Password : </label></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" type="text" name="firstname" placeholder="Firstname" required><label class="form-label" for="floatingInput">Firstname : </label></div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" type="text" name="lastname" placeholder="Lastname" required><label class="form-label" for="floatingInput">Lastname : </label></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" name="birthdate" type="date" required><label class="form-label" for="floatingInput">Birthdate : </label></div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" type="email" name="email" placeholder="Email" required><label class="form-label" for="floatingInput">Email : </label></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3"><select class="form-select" required name="course">
                                        <optgroup label="Course">
                                            <?php get_courses(); ?>
                                        </optgroup>
                                    </select><label class="form-label" for="floatingInput">Course :&nbsp;</label></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3"><select class="form-select" required name="civil">
                                        <optgroup label="Status">
                                            <option value="Single" selected="">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Widow">Widow</option>
                                        </optgroup>
                                    </select><label class="form-label" for="floatingInput">Civil Status : </label></div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col">
                                <div class="form-floating mb-3"><input class="form-control form-control" type="tel" name="phone" placeholder="phone" required><label class="form-label" for="floatingInput">Contact #: </label></div>
                            </div>
                        </div>
                        <div class="form-floating mb-3"><input class="form-control form-control" type="text" name="present_address" placeholder="Present Address" required><label class="form-label" for="floatingInput">Present Address : </label></div>
                        <button class="btn btn-primary w-100 mb-3" type="submit">Add Student</button>
                        <div class="d-flex flex-column align-items-center mb-4"></div>
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>
    

    
    <div class="modal fade" role="dialog" tabindex="-1" id="delete">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this alumni?</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                <form class="needs-validation" action="../functions/administrator/delete-student.php" method="post">
                        <input type="hidden" name="id">
                        <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </div>
            </div>
        </div>
    </div>
   <!-- Approve Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../functions/administrator/approvestudent.php" method="POST">
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
    <!-- Declined Modal -->
    <div class="modal fade" id="declineModal" tabindex="-1" aria-labelledby="declineModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../functions/administrator/declinedstudent.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="declineModalLabel">Decline Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to decline this student?</p>
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
    <!-- Student Details Modal -->
<div class="modal fade" id="studentDetailsModal" tabindex="-1" aria-labelledby="studentDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentDetailsModalLabel">Student Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Id :</strong> <span id="modalUsername"></span></p>
                <p><strong>First Name:</strong> <span id="modalFirstName"></span></p>
                <p><strong>Last Name:</strong> <span id="modalLastName"></span></p>
                <p><strong>Birthdate:</strong> <span id="modalBirthdate"></span></p>
                <p><strong>Age:</strong> <span id="modalAge"></span></p>
                <p><strong>Course:</strong> <span id="modalCourse"></span></p>
                <p><strong>Batch:</strong> <span id="modalBatch"></span></p>
                <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                <p><strong>Address:</strong> <span id="modalPresentAddress"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
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

$("#dataTable").DataTable({
        // dom: 'Blfrtip',
        dom: "Bfrtip",
        responsive: true,
        buttons: [
        //   {
        //     extend: "excel",
        //     title: "ALUMNI ASSOCIATION",
        //     className: "btn btn-primary text-primary",
        //     text: '<i class="fa fa-file-excel"></i> EXCEL',
        //     exportOptions: {
        //       columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
        //     },
        //   },
        //   {
        //     extend: "pdf",
        //     title: "ALUMNI ASSOCIATION",
        //     className: "btn btn-primary text-danger",
        //     text: '<i class="fa fa-file-pdf"></i> PDF',
        //     exportOptions: {
        //       columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
        //     },
        //   },
        //   {
        //     extend: "print",
        //     className: "btn btn-primary text-info",
        //     text: '<i class="fa fa-print"></i> Print',
        //     title: "ALUMNI ASSOCIATION",
        //     autoPrint: true,
        //     exportOptions: {
        //       columns: ":visible",
        //       columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
        //     },
        //     customize: function (win) {
        //       $(win.document.body)
        //         .find("table")
        //         .addClass("display")
        //         .css("font-size", "9px");
        //       $(win.document.body)
        //         .find("tr:nth-child(odd) td")
        //         .each(function (index) {
        //           $(this).css("background-color", "#D0D0D0");
        //         });
        //       $(win.document.body).find("h1").css("text-align", "center");
        //     },
        //   },
        ],
      });
      $('button[data-bs-target="#approve"]').on("click", function () {
        var id = $(this).data("id");
        $('input[name="id"]').val(id);
        console.log(id);
      });  

     document.addEventListener('DOMContentLoaded', function () {
    // Approve modal
    var approveModal = document.getElementById('approveModal');
    approveModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var userId = button.getAttribute('data-id');
        var email = button.getAttribute('data-email');

        // Populate the hidden input fields in the modal
        var modalUserId = approveModal.querySelector('#user_id');
        var modalEmail = approveModal.querySelector('#email');

        modalUserId.value = userId;
        modalEmail.value = email;
    });

    // Decline modal
    var declineModal = document.getElementById('declineModal');
    declineModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var userId = button.getAttribute('data-id');
        var email = button.getAttribute('data-email');

        // Populate the hidden input fields in the modal
        var modalUserId = declineModal.querySelector('#user_id');
        var modalEmail = declineModal.querySelector('#email');

        modalUserId.value = userId;
        modalEmail.value = email;
    });
});

// Get the modal element
// Get the modal element
var viewModal = document.getElementById('view');

// Add event listener when the modal is triggered
viewModal.addEventListener('show.bs.modal', function (event) {
    // Get the button that triggered the modal
    var button = event.relatedTarget;
    
    // Extract the file path from data-file attribute
    var file = button.getAttribute('data-file');
    
    // Get the image element inside the modal
    var filePic = document.getElementById('view-file-pic');
    
    // Update the src of the image with the file path
    filePic.src = file;
});

var studentDetailsModal = document.getElementById('studentDetailsModal');
studentDetailsModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget; // Button that triggered the modal

    // Extract data-* attributes from the button
    var username = button.getAttribute('data-username');
    var firstname = button.getAttribute('data-firstname');
    var lastname = button.getAttribute('data-lastname');
    var birthdate = button.getAttribute('data-birthdate');
    var age = button.getAttribute('data-age');
    var course = button.getAttribute('data-course');
    var batch = button.getAttribute('data-batch');
    var email = button.getAttribute('data-email');
    var present_address = button.getAttribute('data-present_address');

    // Update the modal's content
    var modalUsername = document.getElementById('modalUsername');
    var modalFirstName = document.getElementById('modalFirstName');
    var modalLastName = document.getElementById('modalLastName');
    var modalBirthdate = document.getElementById('modalBirthdate');
    var modalAge = document.getElementById('modalAge');
    var modalCourse = document.getElementById('modalCourse');
    var modalBatch = document.getElementById('modalBatch');
    var modalEmail = document.getElementById('modalEmail');
    var modalPresentAddress = document.getElementById('modalPresentAddress');

    modalUsername.textContent = username;
    modalFirstName.textContent = firstname;
    modalLastName.textContent = lastname;
    modalBirthdate.textContent = birthdate;
    modalAge.textContent = age;
    modalCourse.textContent = course;
    modalBatch.textContent = batch;
    modalEmail.textContent = email;
    modalPresentAddress.textContent = present_address;
});

    </script>

</body>

</html>