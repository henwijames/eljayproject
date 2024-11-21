<?php
require_once '../functions/connection.php';
include_once '../functions/administrator/get-data-table.php';
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
    <title>Course - Alumni Management System for Yllana Bay View College</title>
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
                        <h3 class="text-dark mb-2">Course Management</h3><button class="btn btn-outline-primary mx-2 mb-2" type="button" data-bs-target="#add" data-bs-toggle="modal">Add Course</button>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Course List</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Created At</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php get_course_datatable(); ?>
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
                        <form id="course-form" action="../functions/administrator/add-course.php" method="post">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" name="name" placeholder="Course Name" required>
                                <label for="course_name">Course Name:</label>
                            </div>

                            <button type="button" class="btn btn-secondary" id="add-major">Add+</button>
                            <div id="majors-container">
                                <!-- Initial major input field -->
                                <div class="form-floating mb-3">
                                    <input class="form-control" type="text" name="majors[]" placeholder="Major 1">
                                    <label for="major-1">Major 1:</label>
                                </div>
                            </div>
                            
                            <button class="btn btn-primary w-100" type="submit">Add Course</button>
                        </form>
                    </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>
    <!-- Update Modal -->
    <div class="modal fade" role="dialog" tabindex="-1" id="update">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="../assets/img/navbar.jpg" style="width: 10em;">
                <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="update-course-form" action="../functions/administrator/update-course.php" method="post">
                    <input type="hidden" name="id" id="course-id">
                    
                    <div class="form-floating mb-3">
                                <input class="form-control" type="text" name="name" placeholder="Course Name" required>
                                <label for="course_name">Course Name:</label>
                            </div>

                            <button type="button" class="btn btn-secondary" id="add-major">Add+</button>
                            <div id="majors-container">
                                <!-- Initial major input field -->
                                <div class="form-floating mb-3">
                                    <input class="form-control" type="text" name="majors[]" placeholder="Major 1">
                                    <label for="major-1">Major 1:</label>
                                </div>
                            </div>

                    <button class="btn btn-primary w-100" type="submit">Update Course</button>
                    <div class="d-flex flex-column align-items-center mb-4"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
            </div>
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
                    <p>Are you sure you want to delete this course?</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                <form action="../functions/administrator/delete-course.php" method="post">
                    <input type="hidden" name="id">
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/bs-init.js"></script>
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
    const addMajorButton = document.getElementById('add-major');
    const majorsContainer = document.getElementById('majors-container');
    
    let majorCount = 1; // Start from 1, as we already have one major input field initially

    addMajorButton.addEventListener('click', function() {
        majorCount++;
        const majorInput = document.createElement('div');
        majorInput.classList.add('form-floating', 'mb-3');
        majorInput.innerHTML = `
            <input class="form-control" type="text" name="majors[]" placeholder="Major ${majorCount}" required>
            <label for="major-${majorCount}">Major ${majorCount}:</label>
        `;
        majorsContainer.appendChild(majorInput);
    });
    });
    

    $(document).ready(function() {
    // Function to load courses and majors
    function loadCourseData(courseId) {
        $.ajax({
            url: '../functions/administrator/get-course-data.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Populate course select box
                let courseSelect = $('#course-select');
                courseSelect.empty(); // Clear existing options
                $.each(data.courses, function(index, course) {
                    courseSelect.append($('<option>', {
                        value: course.id,
                        text: course.name
                    }));
                });

                // Populate majors container if a courseId is provided
                if (courseId) {
                    $.ajax({
                        url: '../functions/administrator/get-majors.php',
                        type: 'GET',
                        data: { course_id: courseId },
                        dataType: 'json',
                        success: function(data) {
                            let majorsContainer = $('#majors-container');
                            majorsContainer.empty(); // Clear existing majors
                            $.each(data.majors, function(index, major) {
                                majorsContainer.append(`
                                    <div class="form-floating mb-3">
                                        <input class="form-control form-control" type="text" name="majors[]" value="${major.name}" placeholder="Major" required>
                                        <label class="form-label" for="floatingInput">Major :</label>
                                    </div>
                                `);
                            });
                        }
                    });
                }
            }
        });
    }

    // When the modal is shown
    $('#update').on('shown.bs.modal', function(event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let courseId = button.data('id'); // Extract course ID from data-* attributes
        $('#course-id').val(courseId); // Set hidden input value

        loadCourseData(courseId); // Load course and major data
    });

    // On course select change, update majors
    $('#course-select').on('change', function() {
        let selectedCourseId = $(this).val();
        if (selectedCourseId) {
            loadCourseData(selectedCourseId);
        }
    });
});



    </script>
</body>

</html>