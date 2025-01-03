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
                        <h3 class="text-dark mb-2">Faculty Management for <?php echo $yrow['year']; ?></h3>
                        <div class="d-flex ms-auto">
                            <button class="btn btn-outline-primary mx-2 mb-2" type="button" data-bs-target="#addFaculty" data-bs-toggle="modal">
                                Add Teaching Staff
                            </button>
                            <button class="btn btn-outline-primary mx-2 mb-2" type="button" data-bs-target="#addNonTeachingStaff" data-bs-toggle="modal">
                                Add Non-Teaching Staff
                            </button>
                            <button class="btn btn-outline-primary mx-2 mb-2" type="button" data-bs-target="#addGuest" data-bs-toggle="modal">
                                Add Guest Speaker
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
                                            <th>Fullname</th>
                                            <th>Role</th>
                                            <th>Course/Position</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                        $sql = "SELECT * FROM facultymember WHERE  batch = $batch";
                                        $result = $conn->query($sql);
                                        foreach($result as $row){
                                            ?>
                                            <tr>
                                                <td><?=$row['FULLNAME'];?></td>
                                                <td><?=$row['ROLE'];?></td>
                                                <td>
                                                    <?php
                                                    echo  $row['COURSE'];
                                                    
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                      
                                                        <?php
                                                        if($row['ROLE'] == 'Non-Teaching Staff'){
                                                            ?>
                                                            <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-target="#NonFaculty<?=$row['ID'];?>" data-bs-toggle="modal">
                                                        <i class="fas fa-eye"></i>
                                                        </button>
                                                            
                                                           <?php
                                                        }else if($row['ROLE'] == 'Teaching Staff'){
                                                            ?>
                                                            <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-target="#Faculty<?=$row['ID'];?>" data-bs-toggle="modal">
                                                        <i class="fas fa-eye"></i>
                                                        </button>
                                                            
                                                           <?php
                                                        }else if($row['ROLE'] == 'Guest Speaker'){
                                                            ?>
                                                            <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-target="#Guest<?=$row['ID'];?>" data-bs-toggle="modal">
                                                        <i class="fas fa-eye"></i>
                                                        </button>
                                                            
                                                           <?php
                                                        }
                                                        
                                                        ?>

                                                        <div class="modal fade" id="Guest<?=$row['ID'];?>" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="galleryModalLabel">Gallery</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        
                                                                        <form action="revised.php" method="post">
                                                                            <div class="form-group mb-2">
                                                                                <label for="name" class="form-label">Guest Speaker</label>
                                                                                <input class="form-control" type="text" id="name" value="<?php echo $row['FULLNAME'];?>" name="name" placeholder="Enter Guest Speaker name" required>
                                                                            </div>
                                                                            
                                                                            <input type="text" class="form-control" name="course" value="Guest Speaker" hidden>
                                                                        <input type="text" class="form-control" name="batch" value="<?=$batch;?>" hidden>
                                                                        <input type="text" class="form-control" name="role" value="Guest Speaker" hidden>
                                                                        <input type="hidden" name="id" value="<?=$row['ID']?>">
                                                                        
                                                                        <div class="form-group mb-2">
                                                                                <label for="speech" class="form-label">Speech</label>
                                                                                <textarea class="form-control" id="speech" name="speech" placeholder="Enter Speech" required><?php echo $row['SPEECH']?></textarea>

                                                                            </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-primary" name="savedatafacultyupdate" data-bs-dismiss="modal">Save</button>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="modal fade" id="Faculty<?=$row['ID'];?>" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="galleryModalLabel">Gallery</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        
                                                                        <form action="revised.php" method="post">
                                                                            <div class="form-group mb-2">
                                                                                <label for="name" class="form-label">Faculty Name</label>
                                                                                <input class="form-control" type="text" id="name" value="<?php echo $row['FULLNAME']?>" name="name" placeholder="Enter Faculty Name" required>
                                                                            </div>
                                                                            <div class="form-group mb-2">
                                                                                <label for="course" class="form-label">Course</label>
                                                                                <select class="form-select mb-2" name="course" aria-label="Default select example">
                                                                                <option selected>Select Course</option>
                                                                                <?php
                                                                                $csql = "SELECT * FROM courses";
                                                                                $cres = mysqli_query($conn, $csql);
                                                                                foreach ($cres as $crow) {
                                                                                ?>
                                                                                    <option value="<?= $crow['name'] ?>" <?php if($crow['name']==$row['COURSE']){echo 'selected';}?>><?= $crow['name'] ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            </div>
                                                                        <input type="text" class="form-control" name="batch" value="<?=$batch;?>" hidden>
                                                                        <input type="text" class="form-control" name="role" value="Teaching Staff" hidden>
                                                                        <input type="hidden" name="id" value="<?=$row['ID']?>">
                                                                            

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-primary" name="savedatafacultyupdate" data-bs-dismiss="modal">Save</button>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                     

                                                        <div class="modal fade" id="NonFaculty<?=$row['ID'];?>" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="galleryModalLabel">Non-Teaching Staff</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        
                                                                        <form action="revised.php" method="post">
                                                                            <div class="form-group mb-2">
                                                                                <label for="name" class="form-label">Full Name</label>
                                                                                <input class="form-control" type="text" id="name" name="name" value="<?php echo $row['FULLNAME'];?>" placeholder="Enter Faculty Name" required>
                                                                            </div>
                                                                            <div class="form-group mb-2">
                                                                                <label for="course" class="form-label">Role/Position</label>
                                                                                <select name="course" id="course" class="form-control">
                                                                                    <option value="" selected disabled>Choose Role</option>
                                                                                    <option value="President" <?php if($row['COURSE']=='President'){echo 'selected';}?>>School President</option>
                                                                                    <option value="Vice President" <?php if($row['COURSE']=='Vice President'){echo 'selected';}?>>Vice President</option>
                                                                                    <option value="Dean" <?php if($row['COURSE']=='Dean'){echo 'selected';}?>>Dean</option>
                                                                                    <option value="School Administrator" <?php if($row['COURSE']=='School Administrator'){echo 'selected';}?>>School Administrator</option>
                                                                                    <option value="Registrar" <?php if($row['COURSE']=='Registrar'){echo 'selected';}?>>Registrar</option>
                                                                                    <option value="Accountant" <?php if($row['COURSE']=='Accountant'){echo 'selected';}?>>Accountant</option>
                                                                                    <option value="Cashier" <?php if($row['COURSE']=='Cashier'){echo 'selected';}?>>Cashier</option>
                                                                                    <option value="Librarian" <?php if($row['COURSE']=='Librarian'){echo 'selected';}?>>Librarian</option>
                                                                                    <option value="Guidance Counselor" <?php if($row['COURSE']=='Guidance Counselor'){echo 'selected';}?>>Guidance Counselor</option>
                                                                                    <option value="Secretary" <?php if($row['COURSE']=='Secretary'){echo 'selected';}?>>Secretary</option>
                                                                                    <option value="Clerk" <?php if($row['COURSE']=='Clerk'){echo 'selected';}?>>Clerk</option>
                                                                                    <option value="Utility" <?php if($row['COURSE']=='Utility'){echo 'selected';}?>>Utility</option>
                                                                                    <option value="Security" <?php if($row['COURSE']=='Security'){echo 'selected';}?>>Security</option>
                                                                                    <option value="Others" <?php if($row['COURSE']=='Others'){echo 'selected';}?>>Others</option>


                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group mb-2">
                                                                                <label for="speech" class="form-label">Speech</label>
                                                                                <textarea class="form-control" value="" id="speech" name="speech" placeholder="Enter Speech" required><?php echo $row['SPEECH']?></textarea>

                                                                            </div>
                                                                        <input type="text" class="form-control" name="batch" value="<?=$batch;?>" hidden>
                                                                        <input type="text" class="form-control" name="role" value="Non-Teaching Staff" hidden>
                                                                        <input type="hidden" name="id" value="<?=$row['ID']?>">
                                                                            

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-primary" name="savedatafacultyupdate" data-bs-dismiss="modal">Save</button>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>




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
                                                                        <button type="submit" class="btn btn-danger" name="deletefaculty" data-bs-dismiss="modal">Delete</button>
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
   
</div>
<div class="modal fade" id="addNonTeachingStaff" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalLabel">Non-Teaching Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <form action="revised.php" method="post">
                    <div class="form-group mb-2">
                        <label for="name" class="form-label">Full Name</label>
                        <input class="form-control" type="text" id="name" name="name" placeholder="Enter Faculty Name" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-label">Image</label>
                        <input class="form-control" type="file" name="image" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="course" class="form-label">Role/Position</label>
                        <select name="course" id="course" class="form-control">
                            <option value="" selected disabled>Choose Role</option>
                            <option value="President">School President</option>
                            <option value="Vice President">Vice President</option>
                            <option value="Dean">Dean</option>
                            <option value="School Administrator">School Administrator</option>
                            <option value="Registrar">Registrar</option>
                            <option value="Accountant">Accountant</option>
                            <option value="Cashier">Cashier</option>
                            <option value="Librarian">Librarian</option>
                            <option value="Guidance Counselor">Guidance Counselor</option>
                            <option value="Secretary">Secretary</option>
                            <option value="Clerk">Clerk</option>
                            <option value="Utility">Utility</option>
                            <option value="Security">Security</option>
                            <option value="Others">Others</option>

                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="speech" class="form-label">Speech</label>
                        <textarea class="form-control" id="speech" name="speech" placeholder="Enter Speech" required></textarea>

                    </div>
                   <input type="text" class="form-control" name="batch" value="<?=$batch;?>" hidden>
                   <input type="text" class="form-control" name="role" value="Non-Teaching Staff" hidden>
                    

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="savedatafaculty" data-bs-dismiss="modal">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addFaculty" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalLabel">Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <form action="revised.php" method="post">
                    <div class="form-group mb-2">
                        <label for="name" class="form-label">Faculty Name</label>
                        <input class="form-control" type="text" id="name" name="name" placeholder="Enter Faculty Name" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="course" class="form-label">Course</label>
                        <select class="form-select mb-2" name="course" aria-label="Default select example">
                        <option selected>Select Course</option>
                        <?php
                        $csql = "SELECT * FROM courses";
                        $cres = mysqli_query($conn, $csql);
                        foreach ($cres as $crow) {
                        ?>
                            <option value="<?= $crow['name'] ?>"><?= $crow['name'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    </div>
                   <input type="text" class="form-control" name="batch" value="<?=$batch;?>" hidden>
                   <input type="text" class="form-control" name="role" value="Teaching Staff" hidden>
                    

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="savedatafaculty" data-bs-dismiss="modal">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addGuest" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalLabel">Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <form action="revised.php" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-2">
                        <label for="name" class="form-label">Guest Speaker</label>
                        <input class="form-control" type="text" id="name" name="name" placeholder="Enter Guest Speaker name" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-label">Image</label>
                        <input class="form-control" type="file" name="image" required>
                    </div>
                    
                    <input type="text" class="form-control" name="course" value="Guest Speaker" hidden>
                   <input type="text" class="form-control" name="batch" value="<?=$batch;?>" hidden>
                   <input type="text" class="form-control" name="role" value="Guest Speaker" hidden>
                   <div class="form-group mb-2">
                        <label for="speech" class="form-label">Speech</label>
                        <textarea class="form-control" id="speech" name="speech" placeholder="Enter Speech" required></textarea>

                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="savedatafaculty" data-bs-dismiss="modal">Save</button>
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