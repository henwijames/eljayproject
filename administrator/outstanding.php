<?php
require_once '../functions/connection.php';
include_once '../functions/get-data.php';
include_once '../functions/administrator/get-data-table.php';
include_once '../functions/get-announcement.php';
include_once '../functions/get-batch.php';
require '../functions/conn.php';
if (session_start() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    header('location: ../index.php');
}
if( isset($_POST['batch'])){
    
    $batch = $_POST['batch'];
    //select the year
    $ysql = "SELECT * FROM batch WHERE id = $batch";
    $yresult = $conn->query($ysql);
    $yrow = $yresult->fetch_assoc();
}elseif(isset($_GET['batch'])){
    $batch = $_GET['batch'];
    //select the year
    $ysql = "SELECT * FROM batch WHERE id = $batch";
    $yresult = $conn->query($ysql);
    $yrow = $yresult->fetch_assoc();

}else{
    header('location: index.php');
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>


    
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
                        <h3 class="text-dark mb-2">Outstanding Graduates for batch: <?php echo $yrow['year']; ?></h3>
                        <div class="d-flex ms-auto">
                            <button class="btn btn-outline-primary mx-2 mb-2" type="button" data-bs-target="#addFaculty" data-bs-toggle="modal">
                                Add Outstanding Graduates
                            </button>
                            
                        </div>
                    </div>

                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Faculty</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Course</th>
                                            <th>Achievement</th>
                                            <th>Special Awards</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM outstandingalumni WHERE batch = $batch";
                                        $result = $conn->query($sql);
                                        foreach($result as $row){
                                            $alumnisql = "SELECT * FROM alumnigallery WHERE ID = ".$row['alumniid'];
                                            $alumniresult = $conn->query($alumnisql);
                                            $alumnirow = $alumniresult->fetch_assoc();
                                            $achievementssql = "SELECT * FROM achievements WHERE id = ".$row['achievementid'];
                                            $achievementsresult = $conn->query($achievementssql);
                                            $achievementsrow = $achievementsresult->fetch_assoc();
                                            if($alumnirow['MIDDLENAME'] != ""){
                                                $fullname = $alumnirow['FIRSTNAME']." ".$alumnirow['MIDDLENAME'][0].". ".$alumnirow['LASTNAME'];
                                            }else{
                                                $fullname = $alumnirow['FIRSTNAME']." ".$alumnirow['LASTNAME'];
                                            }
                                        ?>
                                        <tr>
                                            <td><?php echo $fullname; ?></td>
                                            <td><?php $cid = $alumnirow['COURSE'];
                                            $csql = "SELECT * FROM courses WHERE id = $cid";
                                            $cresult = $conn->query($csql);
                                            $crow = $cresult->fetch_assoc();
                                            echo $crow['name']; 
                                            
                                            ?></td>
                                            <td>
                                                <?php echo @$achievementsrow['name']; ?>
                                            </td>
                                            <td><?php echo @$row['specialawards']; ?></td>
                                            <td>
                                                    <div class="d-flex justify-content-center">
                                                        
                                                        <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-target="#deleteFaculty<?=$row['ID'];?>" data-bs-toggle="modal">
                                                        <i class="fas fa-trash"></i>
                                                        </button>
                                                        <div class="modal fade" id="deleteFaculty<?=$row['ID'];?>" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-sm">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="galleryModalLabel"></h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <h5 class="text-center">Are you sure you want to delete?</h5>
                                                                        <form action="revised.php" method="post">
                                                                        <input type="text" class="form-control" name="batch" value="<?=$batch;?>" hidden>
                                                                        <input type="text" class="form-control" name="id" value="<?=$row['ID'];?>" hidden>
                                                                       
                                                                            

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-danger" name="deleteoutstanding" data-bs-dismiss="modal">Delete</button>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                        </tr>
                                        <?php
                                        }
                                        
                                        ?>
                                    </tbody>
                                
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
   
</div>

<div class="modal fade" id="addFaculty" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalLabel">Outstanding Graduates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <form action="revised.php" method="post">
               <!-- Select2 CSS -->
                <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />

                <!-- Select2 JS -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>



                    <div class="form-group mb-2">
                        <label for="name" class="form-label">Alumni Name</label>
                        <select name="alumniid" id="name" class="form-control" with="100%" required>
                            <?php
                            $nsql = "SELECT * FROM alumnigallery WHERE BATCHDATE = $batch";
                            $nres = mysqli_query($conn, $nsql);
                            foreach ($nres as $nrow) {
                                if($nrow['MIDDLENAME'] != ""){
                                    $fullname = $nrow['FIRSTNAME']." ".$nrow['MIDDLENAME'][0].". ".$nrow['LASTNAME'];
                                }else{
                                    $fullname = $nrow['FIRSTNAME']." ".$nrow['LASTNAME'];
                                }
                            ?>
                                <option value="<?= $nrow['ID'] ?>"><?= $fullname; ?></option>
                            <?php
                            }
                            ?>
                        </select>




                    </div>
                    <script>
                    $(document).ready(function () {
                        $('#name').select2({
                            placeholder: 'Search for a name',
                            allowClear: true,
                        });
                    });
                </script>






                <div class="form-group mb-2">
                    <label for="awards" class="form-label">Awards</label>
                    <select class="form-select mb-2" name="awards" aria-label="Default select example" id="awardsSelect">
                        <option selected>Select Awards</option>
                        <?php
                        $csql = "SELECT * FROM achievements";
                        $cres = mysqli_query($conn, $csql);
                        foreach ($cres as $crow) {
                        ?>
                            <option value="<?= $crow['id'] ?>"><?= $crow['name'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group mb-2" id="specialAwardsDiv">
                    <label for="special" class="form-label">Special Awards Name</label>
                    <input type="text" class="form-control" name="special" id="special">
                    <p class="text-muted">Leave this if not special awards</p>
                </div>
                


                   <input type="text" class="form-control" name="batch" value="<?=$batch;?>" hidden>
                  
                    

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="savedoutstanding" data-bs-dismiss="modal">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </form>
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
   
   <?php
   if(isset($_SESSION['stat'])){
    if($_SESSION['stat'] == 'success'){
        ?>
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '<?php echo $_SESSION['message']; ?>',
        })
        </script>
        <?php
    }else{
        ?>
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo $_SESSION['message']; ?>',
        })
        </script>
        <?php
    }

    unset($_SESSION['stat']);
   }
   ?>

    

</body>

</html>