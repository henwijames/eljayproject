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
    <title>Batch - Alumni Management System for LC</title>
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
    <div class="container mt-5">
        <div class="row">
            <!-- Left Container: Add Batch -->
            <div class="col-md-6">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-2">Batch</h3>
                        <button class="btn btn-outline-primary mx-2 mb-2" type="button" data-bs-target="#add" data-bs-toggle="modal">Add Batch Year</button>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Batch Year List</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Batch Year</th>
                                            <th>Created At</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php get_batch_datatable(); ?>
                                    </tbody>
                                    <tfoot>
                                        <tr></tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-2">Achievements</h3>
                        <button class="btn btn-outline-primary mx-2 mb-2" type="button" data-bs-target="#add_achv" data-bs-toggle="modal">Add Achievement's</button>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Achievement List</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Batch Year</th>
                                            <th>Created At</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php get_achievements_datatable(); ?>
                                    </tbody>
                                    <tfoot>
                                        <tr></tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </section> -->
        </div>
    </div>
<?php include_once '../functions/administrator/offcanva-menu.php'; ?>
    <div class="modal fade" role="dialog" tabindex="-1" id="add">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header"><img src="../assets/img/navbar.jpg" style="width: 10em;">
                <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <form action="../functions/administrator/add-batch.php" method="post">
                        <div class="form-floating mb-3"><input class="form-control form-control" type="text" name="year" placeholder="Batch Year :" required=""><label class="form-label" for="floatingInput">Batch Year :</label></div>
                        <button class="btn btn-primary w-100" type="submit">Add Batch Year</button>
                        <div class="d-flex flex-column align-items-center mb-4"></div>
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
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
                <form action="../functions/administrator/update-batch.php" method="post">
                    <!-- Hidden input for ID -->
                    <input type="hidden" name="id" id="update-batch-id">

                    <!-- Input for Batch Year -->
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" name="year" placeholder="Batch Year" id="batch-name" required="">
                        <label class="form-label" for="floatingInput">Batch Year :</label>
                    </div>

                    <!-- Submit Button -->
                    <button class="btn btn-primary w-100" type="submit">Update Batch</button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    

    
    <!-- Achievements modal -->
    <div class="modal fade" role="dialog" tabindex="-1" id="add_achv">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header"><img src="../assets/img/navbar.jpg" style="width: 10em;">
                <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <form action="../functions/administrator/add-achievements.php" method="post">
                        <div class="form-floating mb-3"><input class="form-control form-control" type="text" name="name" placeholder="Achievements :" required=""><label class="form-label" for="floatingInput">Achievements :</label></div>
                        <button class="btn btn-primary w-100" type="submit">Add Achievements</button>
                        <div class="d-flex flex-column align-items-center mb-4"></div>
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="update_achv" tabindex="-1" aria-labelledby="update_achv_label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="../assets/img/navbar.jpg" style="width: 10em;">
                <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="../functions/administrator/update-achievements.php" method="post">
                    <!-- Hidden input for ID -->
                    <input type="hidden" name="id" id="update-achievement-id">

                    <!-- Input for Achievement Name -->
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" name="name" id="achievement-name" placeholder="Achievements" required="">
                        <label class="form-label" for="achievement-name">Achievements :</label>
                    </div>

                    <!-- Submit Button -->
                    <button class="btn btn-primary w-100" type="submit">Update Achievement</button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>

    <div class="modal fade" role="dialog" tabindex="-1" id="delete_achv">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this achievement?</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                <form action="../functions/administrator/delete-achievements.php" method="post">
                <input type="hidden" name="id" id="delete-achievement-id">
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
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
                    <p>Are you sure you want to delete this batch?</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                <form action="../functions/administrator/delete-batch.php" method="post">
                    <input type="hidden" name="id" id="delete-batch-id">
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </div>
            </div>
        </div>
    </div>
    <script>
    // Populate modal with the achievement ID
    document.querySelectorAll('[data-bs-target="#update"]').forEach(button => {
        button.addEventListener('click', () => {
            const batchId = button.getAttribute('data-id');
            const batchName = button.getAttribute('data-name');

            // Set the achievement ID in the hidden input
            document.getElementById('update-batch-id').value = batchId;
            
            // Set the achievement name in the input field
            document.getElementById('batch-name').value = batchName;
        });
    });
    document.querySelectorAll('[data-bs-target="#delete"]').forEach(button => {
        button.addEventListener('click', () => {
            const batchId = button.getAttribute('data-id');
            document.getElementById('delete-batch-id').value = batchId;
        });
    });


    document.querySelectorAll('[data-bs-target="#delete_achv"]').forEach(button => {
        button.addEventListener('click', () => {
            const achievementId = button.getAttribute('data-id');
            document.getElementById('delete-achievement-id').value = achievementId;
        });
    });
    
    document.querySelectorAll('[data-bs-target="#update_achv"]').forEach(button => {
        button.addEventListener('click', () => {
            const achievementId = button.getAttribute('data-id');
            const achievementName = button.getAttribute('data-name');

            // Set the achievement ID in the hidden input
            document.getElementById('update-achievement-id').value = achievementId;
            
            // Set the achievement name in the input field
            document.getElementById('achievement-name').value = achievementName;
        });
    });
    </script>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/bs-init.js"></script>
    <script src="../assets/js/datatables.min.js"></script>
    <script src="../assets/js/three.min.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script src="../assets/js/Lightbox-Gallery.js"></script>
    <script src="../assets/js/Lightbox-Gallery-baguetteBox.min.js"></script>
    <script src="../assets/js/sweetalert2.all.min.js"></script>
    <script src="../assets/js/vanta.fog.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>