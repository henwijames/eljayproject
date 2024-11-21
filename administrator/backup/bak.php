<?php
require_once '../functions/connection.php';
include_once '../functions/get-batch.php';
include_once '../functions/student/get-students.php';
include_once '../functions/administrator/get-data-table.php';
if (session_start() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    header('location: ../index.php');
}
$achievements = getAchievements(); // Add this line to fetch achievements
?>
<!DOCTYPE html>
<html data-bs-theme="light" id="bg-animate" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Gallery - Alumni Management System for Yllana Bay View College</title>
    <meta name="twitter:image" content="https://student.lemerycolleges.edu.ph/images/favicon.png">
    <meta name="description" content="Web-Based Alumni Management System for Yllana Bay View College">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png">
    <link rel="icon" type="image/webp" sizes="450x450" href="https://student.lemerycolleges.edu.ph/images/favicon.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/Nunito.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/css/datatables.min.css">
    <link rel="stylesheet" href="../assets/css/Hero-Clean-images.css">
    <link rel="stylesheet" href="../assets/css/Lightbox-Gallery-baguetteBox.min.css">
    <link rel="stylesheet" href="../assets/css/Login-Form-Basic-icons.css">
    <script>
function updateStudentInfo() {
    const studentSelect = document.getElementById('studentSelect');
    const selectedValue = studentSelect.value;
    document.getElementById('studentId').value = selectedValue; // Set the hidden input value

    const students = [
        <?php
        foreach ($students as $student) {
            echo "{
                id: {$student['id']},
                firstname: '{$student['firstname']}',
                lastname: '{$student['lastname']}',
                profile_pic: '{$student['profile_pic']}',
                batch: '{$student['batch']}',
                course: '{$student['course']}'
            },"; 
        }
        ?>
    ];

    const selectedStudent = students.find(student => student.id == selectedValue);
    const infoSection = document.getElementById('studentInfo');

    if (selectedStudent) {
        const profilePicSrc = `../student/images/${selectedStudent.profile_pic}`;
        infoSection.innerHTML = `
            <div class="card mt-3">
                <img src="${profilePicSrc}" id="studentImage" class="card-img-top" alt="${selectedStudent.firstname} ${selectedStudent.lastname}" style="width: 50%; height: auto; margin: auto;">
                <div class="card-body text-center">
                    <h5 class="card-title">${selectedStudent.firstname} ${selectedStudent.lastname}</h5>
                    <p class="card-text">Batch: ${selectedStudent.batch}</p>
                    <p class="card-text">Course: ${selectedStudent.course}</p>
                </div>
            </div>
        `;
        
        // Show the current profile picture
        document.getElementById('studentImage').src = profilePicSrc;
        document.getElementById('studentImage').style.display = 'block'; // Show image
    } else {
        infoSection.innerHTML = '';
        document.getElementById('studentImage').style.display = 'none'; // Hide image if no student is selected
    }
}


function previewProfilePic() {
    const profilePicInput = document.getElementById('profilePic');

    if (profilePicInput.files && profilePicInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const studentImage = document.getElementById('studentImage');
            studentImage.src = e.target.result; // Update the image with the new file
            studentImage.style.display = 'block'; // Show the uploaded image
        };
        reader.readAsDataURL(profilePicInput.files[0]);
    }
}
    </script>
</head>
<style>
    .custom-dropdown {
    position: relative;
    width: 100%;
    max-width: 300px; /* Adjust width for responsiveness */
}

.dropdown-container {
    display: inline-block;
    width: 100%;
}

.dropdown-selected {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    cursor: pointer;
}

.search-bar {
    width: calc(100% - 20px); /* Full width minus padding */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin: 5px; /* Add some spacing around the search bar */
}

.dropdown-list {
    display: none; /* Hidden by default */
    position: absolute;
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
    z-index: 1;
    max-height: 200px; /* Set a max height for scrolling */
    overflow-y: auto; /* Enable vertical scrolling */
}

.dropdown-list.show {
    display: block; /* Show on toggle */
}

.dropdown-item {
    padding: 10px;
    cursor: pointer;
}

.dropdown-item:hover {
    background-color: #f0f0f0;
}

.arrow {
    margin-left: 10px;
}

/* Responsive styles for smaller screens */
@media (max-width: 480px) {
    .custom-dropdown {
        max-width: 100%; /* Allow full width on small screens */
    }
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
                        <h3 class="text-dark mb-2">Gallery Management</h3>
                        <button class="btn btn-outline-primary mx-2 mb-2" type="button" data-bs-target="#add" data-bs-toggle="modal">Add Alumni</button>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold"> List</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Filename</th>
                                            <th>Course</th>
                                            <th>Batch</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php get_gallery(); ?>
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
            <div class="modal-header">
                <img src="../assets/img/navbar.jpg" style="width: 10em;">
                <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <form action="../functions/administrator/add-gallery.php" method="post" enctype="multipart/form-data" class="p-3">
    <!-- Student Selection Dropdown -->
    <div class="mb-3">
    <label for="studentSelect" class="form-label">Choose a Student:</label>
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="dropdownStudent" data-bs-toggle="dropdown" aria-expanded="false">
            Select a student
        </button>
        <ul class="dropdown-menu w-100" aria-labelledby="dropdownStudent" id="studentDropdownList">
            <li class="px-3">
                <input type="text" id="studentSearch" class="form-control mb-2" placeholder="Type to search for a student..." onkeyup="filterStudents()">
            </li>
            <!-- Student List -->
            <?php if (!empty($students)) : ?>
                <?php foreach ($students as $student) : ?>
                    <li><button class="dropdown-item" type="button" onclick="selectStudent('<?php echo $student['id']; ?>', '<?php echo $student['firstname'] . ' ' . $student['lastname']; ?>')"><?php echo $student['firstname'] . ' ' . $student['lastname']; ?></button></li>
                <?php endforeach; ?>
            <?php else : ?>
                <li><span class="dropdown-item-text">No students available</span></li>
            <?php endif; ?>
        </ul>
    </div>
</div>

    <!-- Hidden Field to Store Selected Student ID -->
    <input type="hidden" name="student_id" id="studentId" value="">

    <!-- Student Info -->
    <div id="studentInfo" class="mt-2"></div>

    <!-- Achievement Dropdown -->
    <div class="mb-3">
        <label for="achievementSelect" class="form-label">Achievement:</label>
        <select id="achievementSelect" class="form-select" name="achievement_id">
            <option value="">Select an Achievement (Optional)</option>
            <?php foreach ($achievements as $achievement) : ?>
                <option value="<?php echo $achievement['id']; ?>"><?php echo $achievement['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Motto Input -->
    <div class="mb-3">
        <label for="motto" class="form-label">Motto:</label>
        <input type="text" class="form-control" name="motto" placeholder="Enter Motto">
    </div>

    <!-- Profile Picture Upload -->
    <div class="mb-3">
        <label for="profilePic" class="form-label">Change Profile Picture:</label>
        <input class="form-control" type="file" id="profilePic" name="profile_pic" accept="image/*" onchange="previewProfilePic()">
        <img id="studentImage" src="../assets/img/default_profile.png" alt="Profile Picture" class="img-fluid mt-2" style="width: 100px; height: auto; display: none;">
    </div>

    <!-- Submit Button -->
    <button class="btn btn-primary w-100" type="submit">Upload</button>
</form>

            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Update Modal -->
<div class="modal fade" id="update" tabindex="-1" aria-labelledby="updateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Achievement and Profile</h5>
                <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="../functions/administrator/update-achievement.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="student_id" id="studentId" value="">
                    
                    <div id="studentInfo">
                        <!-- Student information will be displayed here -->
                    </div>

                    <label for="achievementSelect" class="form-label mt-3">Achievement:</label>
                    <select id="achievementSelect" class="form-select" name="achievement_id">
                        <option value="">Select an Achievement (Optional)</option>
                        <?php
                        foreach ($achievements as $achievement) {
                            echo "<option value='{$achievement['id']}'>{$achievement['name']}</option>";
                        }
                        ?>
                    </select>

                    <label for="motto" class="form-label mt-3">Motto:</label>
                    <input class="form-control" type="text" name="moto" id="motto" placeholder="Enter Motto">

                    <label for="profilePic" class="form-label mt-3">Change Profile Picture:</label>
                    <input class="form-control mb-3" type="file" id="profilePic" name="profile_pic" accept="image/*" onchange="previewProfilePic()">
                    <img id="studentImage" src="../assets/img/default_profile.png" alt="Profile Picture" class="img-fluid mt-2" style="width: 100px; height: auto; display: none;">

                    <!-- Submit Button -->
                    <button class="btn btn-primary w-100" type="submit">Update</button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Delete Modal -->
<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this student?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="deleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
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
    <script>
        $(document).ready(function() {
            $('#student-select').select2({
                placeholder: "Select a Student",
                allowClear: true
            });
        });

        function loadStudentData(studentId) {
    const studentIdField = document.getElementById('studentId');
    const studentInfoDiv = document.getElementById('studentInfo');

    // Clear previous info
    studentInfoDiv.innerHTML = '';

    if (studentId) {
        studentIdField.value = studentId;

        // Fetch student details using AJAX
        fetch(`get_student.php?id=${studentId}`) // Adjust the URL as necessary
            .then(response => response.json())
            .then(data => {
                // Display student information
                studentInfoDiv.innerHTML = `
                    <div>
                        <strong>First Name:</strong> ${data.firstname} <br>
                        <strong>Last Name:</strong> ${data.lastname} <br>
                        <strong>Current Achievement:</strong> ${data.achievement_name || 'None'} <br>
                        <strong>Motto:</strong> ${data.moto || 'None'} <br>
                    </div>
                `;

                // Show the current profile picture if available
                if (data.profile_pic) {
                    document.getElementById('studentImage').src = data.profile_pic; // Adjust the path if needed
                    document.getElementById('studentImage').style.display = 'block';
                } else {
                    document.getElementById('studentImage').src = '../assets/img/default_profile.png';
                    document.getElementById('studentImage').style.display = 'none';
                }

                // Set existing motto if available
                document.getElementById('motto').value = data.moto || '';
            })
            .catch(error => console.error('Error fetching student data:', error));
    } else {
        studentIdField.value = '';
        studentInfoDiv.innerHTML = '';
        document.getElementById('studentImage').style.display = 'none';
    }
}

function openUpdateModal(studentId) {
    loadStudentData(studentId); // Load the student's current information
    const modal = new bootstrap.Modal(document.getElementById('update'));
    modal.show(); // Show the modal
}

function selectStudent(id, name, motto, profilePic) {
    // Set selected student ID
    document.getElementById('studentId').value = id;

    // Change button text to selected student
    document.getElementById('dropdownStudent').innerText = name;

    // Populate student info
    document.getElementById('studentInfo').innerHTML = `
        <div class="student-details">
            <h5>${name}</h5>
            <p><strong>Motto:</strong> ${motto}</p>
            <img src="${profilePic}" alt="Profile Picture" class="img-fluid" style="width: 100px; height: auto;">
        </div>
    `;
}

function filterStudents() {
    const input = document.getElementById('studentSearch').value.toLowerCase();
    const items = document.querySelectorAll('#studentDropdownList .dropdown-item');

    items.forEach(item => {
        if (item.innerText.toLowerCase().includes(input)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

function previewProfilePic() {
    const file = document.getElementById('profilePic').files[0];
    const img = document.getElementById('studentImage');
    if (file) {
        img.style.display = 'block';
        img.src = URL.createObjectURL(file);
    }
}


    </script>

    
</body>

</html>