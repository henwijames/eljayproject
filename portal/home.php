<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "lc");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $student_id = $_SESSION['id'];
    
    // Query to get student and user details
    $stmt = $conn->prepare("
        SELECT s.*, u.username, s.batch
        FROM students s
        JOIN users u ON s.user_id = u.id
        WHERE s.user_id = ?
    ");
    $stmt->bind_param("i", $student_id); // Bind the integer parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $fullName = $student['firstname'] . ' ' . $student['lastname'];
        $age =  date_diff(date_create($student['birthdate']), date_create('now'))->y;

        // Fetch batch information using the batch from the students table
        $batch = $student['batch'];
        $batchStmt = $conn->prepare("
        SELECT id, year
        FROM batch
        WHERE id = ?
        ");
        $batchStmt->bind_param("i", $batch); // Use the student's batch id
        $batchStmt->execute();
        $batchResult = $batchStmt->get_result();

        
        if ($batchResult && $batchResult->num_rows > 0) {
            $batch = $batchResult->fetch_assoc();
            $startYear = $batch['year'];
        } else {
            $startYear = 'Not Available';
        }

        $batchStmt->close();
        
        // Fetch all batches for display
        $allBatchesStmt = $conn->prepare("SELECT id, year FROM batch");
        $allBatchesStmt->execute();
        $allBatchesResult = $allBatchesStmt->get_result();
        
        $batches = [];
        if ($allBatchesResult && $allBatchesResult->num_rows > 0) {
            while ($row = $allBatchesResult->fetch_assoc()) {
                $batches[] = $row;
            }
        }

        $allBatchesStmt->close();
    } else {
        $student = null;
        $fullName = 'Not Available';
    }

    $stmt->close();
    mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Generate student Profile -  Barangay Management System</title>
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
    .card {
    width: 100%;
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.grid-container {
    display: grid;
    grid-template-columns: 20% 40% 20% 20%; /* Column widths */
}

.grid-item {
    padding: 20px;
    text-align: center; /* Center text by default */
}

.grid-item.text-left {
    text-align: left; /* Override text alignment for the second column */
}

.two-column {
    display: grid;
    grid-template-columns: 1fr 1fr; /* Two equal columns */
    gap: 10px; /* Space between columns */
    position: relative; /* Position relative to place the dividing line */
}

.two-column::before {
    content: "";
    position: absolute;
    top: 0;
    left: 50%;
    width: 1px; /* Width of the dividing line */
    height: 100%;
    background-color: #000; /* Color of the dividing line */
    transform: translateX(-50%); /* Center the line */
}

.two-column .grid-item h5 {
    text-align: left; /* Align headings to the left */
}

.two-column .grid-item p {
    text-align: left; /* Align paragraphs to the left */
}
@media (max-width: 768px) {
.card {
    width: 100%;
    padding: 10px;
}

.grid-container {
    grid-template-columns: 1fr;
}
}
/* Modal styles */
.modal {
display: none; /* Hidden by default */
position: fixed; /* Stay in place */
left: 0;
top: 0;
width: 100%; /* Full width */
height: 100%; /* Full height */
overflow: auto; /* Enable scroll if needed */
background-color: rgb(0,0,0); /* Fallback color */
background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

.modal-content {
background-color: #fefefe;
margin: 15% auto;
padding: 20px;
border: 1px solid #888;
width: 80%; /* Could be more or less, depending on screen size */
}

.close-btn {
color: #aaa;
float: right;
font-size: 28px;
font-weight: bold;
}

.close-btn:hover,
.close-btn:focus {
color: black;
text-decoration: none;
cursor: pointer;
}
img.img-fluid {
max-width: 150px;
}
.card {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .card-body {
            margin: 10px 0;
        }

        .grid-container {
            display: grid;
            grid-template-columns: 30% 40% 30%; /* Column widths */
        }

        .grid-item {
            padding: 20px;
            text-align: center; /* Center text by default */
        }

        .grid-item.text-left {
            text-align: left; /* Override text alignment for the second column */
        }

        .batch-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Responsive 3 columns layout */
            gap: 20px; /* Space between cards */
        }

        .batch-card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative; /* For positioning the button */
        }

        .batch-card p {
            margin: 0;
        }

        .view-yearbook-btn {
            position: absolute;
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
        }

        .view-yearbook-btn:hover {
            background-color: #0056b3;
        }
</style>
<body>
<div class="d-flex flex-column" id="content-wrapper">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Student Profile</div>
            <!-- <div class="card-tools">
                <button class="btn btn-info btn-border btn-round btn-sm" onclick="printDiv('printThis')">
                    <i class="fa fa-print"></i>
                    Print Report
                </button>
            </div> -->
        </div>
        <div class="card-body m-5" id="printThis">
            <div class="grid-container">
                <div class="grid-item">
                    <img src="<?= preg_match('/data:image/i', $student['profile_pic']) ? $student['profile_pic'] : '../student/images/'.$student['profile_pic'] ?>" alt="Student Profile" class="img-fluid">
                </div>
                <div class="grid-item text-left">
                    <p>Student Number - <?= $student['username'] ?></p>
                    <p>Full Name - <?= $fullName ?></p>
                    <p>Age - <?php echo $age ?></p>
                    <p>Batch - <?= $startYear ?></p>
                    <p>Birthdate - <?= date('F d, Y', strtotime($student['birthdate'])) ?></p>
                    <p>Address - <?= ucwords(trim($student['present_address'])) ?></p>
                    <p>Contact - <?= $student['phone'] ?></p>
                </div>
                
                <div class="grid-item">
                <img src="<?= preg_match('/data:image/i', $student['qrimage']) ? $student['qrimage'] : '../functions/student/qrcodes/'.$student['qrimage'] ?>" alt="Student Profile" class="img-fluid">
                </div>
            </div>
            <a href="logout.php" class="nav__link nav__logout">
        <i class='bx bx-log-out nav__icon'></i>
        <span class="nav__name" id="log_out">Logout</span>
    </a>
        </div>
    </div>

    <div class="card">
    <div class="card-header">
        <div class="card-title">Batch Information</div>
    </div>
    <div class="card-body">
        <div class="batch-container">
            <?php if (!empty($batch)) : ?>
                <div class="batch-card">
                    <p><strong></strong> <?= $batch['year'] ?></p>
                    <a href="yearbook.php?batch=<?= $batch['id'] ?>" class="view-yearbook-btn mt-3">View Yearbook</a>
                </div>
            <?php else : ?>
                <p>No batch information is available at the moment.</p>
            <?php endif; ?>
        </div>
        </div>
    </div>


    <footer class="bg-white sticky-footer shadow-sm shadow-sm">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © Alumni Management System for Yllana Bay View College 2023</span></div>
            </div>
        </footer>
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
        <script src="../assets/js/vanta.fog.min.js"></script>
        <script src="../assets/js/main.js"></script>		
    <script>
         function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = '<html><head><title>Print</title></head><body>' + printContents + '</body></html>';

        window.print();

        document.body.innerHTML = originalContents;
    }
    document.addEventListener("DOMContentLoaded", function() {
    var modal = document.getElementById("pensionStatusModal");
    var btn = document.querySelector(".btn-secondary"); // Button that opens the modal
    var span = document.getElementsByClassName("close-btn")[0];
    
    // Open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // Close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
});

// Update pension status
function updatePensionStatus() {
    var status = document.getElementById("pensionStatus").value;
    var studentId = document.getElementById("studentId").value;
    var statusMessage = document.getElementById("statusMessage");

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_pension_status.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                statusMessage.innerHTML = "<p>Status updated successfully.</p>";
            } else {
                statusMessage.innerHTML = "<p>Failed to update status. Please try again.</p>";
            }
        }
    };
    xhr.send("pensionStatus=" + status + "&studentId=" + studentId);
}


    </script>
</body>
</html>
<?php 
}else{
     header("Location: index.php");
     exit();
}
 ?>