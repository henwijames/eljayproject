<?php
require_once 'functions/connection.php';
include_once 'functions/get-data.php';
include_once 'functions/get-announcement.php';
include_once 'functions/get-batch.php';
include_once 'functions/get-gallery.php';
if (session_start() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['username'])) {
    if ($_SESSION['type'] === 'administrator') {
        header('location: administrator');
    } else {
        header('location: student');
    }
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
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Nunito.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <link rel="stylesheet" href="assets/css/Hero-Clean-images.css">
    <link rel="stylesheet" href="assets/css/Lightbox-Gallery-baguetteBox.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Basic-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    .notification {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #4CAF50;
        color: white;
        padding: 15px;
        border-radius: 5px;
        font-size: 16px;
        z-index: 9999;
        opacity: 1;
        transition: opacity 0.5s ease;
    }

    .notification.success {
        background-color: #4CAF50;
        /* Green */
    }
</style>
<header id="header" class="fixed-top">
    <div class="container-fluid bs">
        <div class="container d-flex justify-content-between align-items-center">
            <div id="logo">
                <img src="https://student.lemerycolleges.edu.ph/images/favicon.png" alt="Lemery College Logo">
                <a href="index.php" class="text-white">

                    Web-based Alumni Yearbook
                </a>
            </div>
            <div class="right">
                <button class="btn rounded-3 ms-4 shadow-sm text-white"
                    data-bss-hover-animate="pulse"
                    type="button"
                    data-bs-target="#register"
                    data-bs-toggle="modal"
                    aria-label="Login Button">
                    &nbsp;Register
                </button>
                <button class="btn btn rounded-3 ms-4 shadow-sm text-white"
                    data-bss-hover-animate="pulse"
                    type="button"
                    data-bs-target="#login"
                    data-bs-toggle="modal"
                    aria-label="Login Button">
                    &nbsp;Login
                </button>
                <i class="bi bi-list mobile-nav-toggle text-light" aria-label="Toggle Navigation"></i>
            </div>
        </div>
    </div>
    <div class="container-fluid d-flex align-items-center header-transparent" style="background-color: white;">
        <div class="container d-flex justify-content-center"> <!-- Centering the navbar container -->
            <nav id="navbar" class="navbar d-flex justify-content-center"> <!-- Set the navbar to flex -->
                <ul class="navbar-nav d-flex flex-row"> <!-- Make the nav items flex in a row -->
                    <li class="nav-item"><a class="nav-link scrollto active" href="#hero">Home</a></li>
                    <li class="nav-item"><a class="nav-link scrollto" href="#mission">Welcome</a></li>
                </ul>
            </nav><!-- .navbar -->
        </div>
    </div>
</header><!-- End Header -->




<body>
    <section id="hero">
        <div class="hero-container" data-aos="zoom-in" data-aos-delay="100">
            <h1 style=color:#006BFF;>Welcome LCIANS Alumni</h1>
            <h2>The Right Choice</h2>
            <a href="portal/index.php" class="btn-get-started">Go to Portal</a>
        </div>
    </section><!-- End Hero Section -->

    <main id="main">

        <section id="mission">
            <div class="section-header">
                <h3 class="section-title mt-3">Welcome</h3>
            </div>
            <div class="container text-center mt-5">
                <p>Lemery Colleges is one of the leading tertiary institutions in the first district of Batangas.
                    Established in 1994, it was founded by Mr. Oscarlito M. Hernandez and his wife, Mrs.
                    Filomena Hernandez. Located at Brgy. Bagong Sikat, Lemery, Batangas, the institution offers
                    a variety of college courses and Junior High School. With the introduction of the K-12 curriculum,
                    Lemery Colleges now also offers Senior High School programs.</p>
                <p>At present, Lemery Colleges continues to see a steady increase in enrollment. Recognized for its
                    degree programs, the institution remains committed to sustaining its growth and will continue striving
                    for excellence in the coming years.</p>
            </div>
        </section>




        <!-- <section id="contact" class="contact">
  <div class="container" data-aos="fade-up">

    <div class="section-header">
      <h3 class="section-title">Contact Us</h3>
      <p class="section-description">Feel free to reach out to us with any questions or inquiries.</p>
    </div>

    <div class="row contact-info">

      <div class="col-md-4">
        <div class="contact-address">
            
          <address><i class="fas fa-map-pin"></i> 4337 Chabot Drive, Pleasanton, CA 94588Julie Hansen-Orvis | CA DRE# 00934447</address>
        </div>
      </div>

      <div class="col-md-4">
        <div class="contact-phone">
            
          <p><i class="fas fa-phone"></i> <a href="tel:(925) 553-6707">(925) 553-6707</a></p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="contact-email">
            
          <p><i class="fas fa-envelope ms-4"></i> <a href="luxuryhomesinwc@icloud.com">luxuryhomesinwc@icloud.com</a></p>
        </div>
      </div>

    </div>

<div class="row mt-5">
  <div class="col-lg-12">
    <form action="" method="post">
      <div class="row">
        <div class="col-lg-6">
          <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Name" required>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="form-group">
            <input type="text" class="form-control" name="phone" placeholder="Phone" required>
          </div>
        </div>

        <div class="col-lg-12 mt-1">
          <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email" required>
          </div>
        </div>

        <div class="col-lg-12 mt-1">
          <div class="form-group">
            <textarea class="form-control" rows="5" name="message" placeholder="Message" required></textarea>
          </div>
        </div>

        <div class="col-lg-12 mt-1">
          <div class="form-group">
            <input type="checkbox" id="approveCheckbox" required>
            <label for="approveCheckbox">By providing Julie Hansen Partnership your contact information, you acknowledge and agree to our Privacy Policy and consent to receiving marketing communications, including through automated calls, texts, and emails, some of which may use artificial or prerecorded voices. This consent isn’t necessary for purchasing any products or services and you may opt out at any time. To opt out from texts, you can reply, ‘stop’ at any time. To opt out from emails, you can click on the unsubscribe link in the emails. Message and data rates may apply.</label><br><br>
          </div>
        </div>

        <div class="col-lg-12 mt-2">
          <button type="submit" class="btn btn-primary form-control">Send Message</button>
        </div>
      </div>
    </form>
  </div>
</div>

  </div>
</section>End Contact Section -->



    </main><!-- End #main -->

    </div>
    <!-- Footer -->
    <footer class="text-center mt-4 py-4" style="background-color: #102C57; color: white;">
        <div class="container">
            <p class="mb-0">© <?= date('Y') ?> Yearbook. All rights reserved.</p>
            <p>
                <a href="privacy_policy.php" class="text-light">Privacy Policy</a> |
                <a href="terms_of_service.php" class="text-light">Terms of Service</a>
            </p>
        </div>
    </footer>

    <div class="modal fade" role="dialog" tabindex="-1" id="login">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header"><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="d-flex flex-column align-items-center mb-4"><img class="mb-3 rounded-circle" src="https://student.lemerycolleges.edu.ph/images/favicon.png" style="width: 5em;">
                        <h2 class="text-center"><span style="color: rgb(78, 115, 223);">WELCOME&nbsp;</span>Lemery Colleges Alumni's</h2>
                    </div>
                    <form action="functions/login.php" method="post">
                        <div class="form-floating mb-3"><input class="form-control form-control" type="text" name="username" placeholder="Username"><label class="form-label" for="floatingInput">Username : </label></div>
                        <div class="form-floating mb-3"><input class="form-control form-control" type="password" name="password" placeholder="Password"><label class="form-label" for="floatingInput">Password : </label></div><button class="btn btn-primary w-100 mb-3" role="button" type="submit">Sign In</button>

                        <div class="mt-2"><a href="#" data-bs-target="#forgot-password" data-bs-toggle="modal"> Forgot Password</a></div>
                        <div class="mt-5">Not yet a member?<a href="#" data-bs-target="#register" data-bs-toggle="modal"> here</a></div>


                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="forgot-password">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header"><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="d-flex flex-column align-items-center mb-4"><img class="mb-3 rounded-circle" src="https://student.lemerycolleges.edu.ph/images/favicon.png" style="width: 5em;">
                        <h2 class="text-center">Reset Password</h2>
                    </div>
                    <form action="reset.php" method="post">
                        <div class="form-floating mb-3">
                            <input class="form-control form-control" type="email" name="email" placeholder="Email">
                            <label class="form-label" for="floatingInput">Email : </label>
                            </div>
                        <button class="btn btn-primary w-100 mb-3" name="reset" role="button" type="submit">Reset Password</button>


                       

                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="register">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="assets/img/navbar.jpg" style="width: 10em;">
                    <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" action="functions/student/register.php" method="post" enctype="multipart/form-data" novalidate>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="username" type="number" name="username" placeholder="Enter Student Number" required>
                                    <label class="form-label" for="username">Student Number:</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="password" type="password" name="password" placeholder="Password" required>
                                    <label class="form-label" for="password">Password:</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="firstname" type="text" name="firstname" placeholder="Firstname" required>
                                    <label class="form-label" for="firstname">Firstname:</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="middlename" type="text" name="middlename" placeholder="Lastname" required>
                                    <label class="form-label" for="middlename">Middlename:</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="lastname" type="text" name="lastname" placeholder="Lastname" required>
                                    <label class="form-label" for="lastname">Lastname:</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input class="form-control" name="birthdate" type="date" required>
                                    <label class="form-label">Birthdate:</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input class="form-control" type="email" name="email" placeholder="Email" required>
                                    <label class="form-label">Email:</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select class="form-select" required name="course" id="course">
                                        <optgroup label="Course">
                                            <?php get_courses(); ?>
                                        </optgroup>
                                    </select>
                                    <label class="form-label">Course:</label>
                                </div>
                            </div>
                            <div class="col">
                                <label class="form-label">Majors:</label>
                                <div id="majors-container">
                                    <!-- Checkboxes for majors will be populated dynamically -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select class="form-select" required name="civil">
                                        <optgroup label="Status">
                                            <option value="Single" selected="">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Widow">Widow</option>
                                        </optgroup>
                                    </select>
                                    <label class="form-label">Civil Status:</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select class="form-select" required name="batch">
                                        <optgroup label="Batch">
                                            <?php get_batches(); ?>
                                        </optgroup>
                                    </select>
                                    <label class="form-label">Batch:</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input class="form-control" type="number" name="phone" placeholder="Phone" maxlength="11" oninput="this.value = this.value.slice(0, 11)">
                                    <label class="form-label">Contact #:</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col">
    <div class="form-floating mb-3">
        <input 
            class="form-control" 
            type="file" 
            name="file" 
            id="uploadfile" 
            required 
            accept="image/png, image/jpeg, image/jpg"
        >
        <label class="form-label">Authorization :</label>
    </div>
    <script>
        document.getElementById('uploadfile').addEventListener('change', function (event) {
            const file = event.target.files[0];

            if (file) {
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                const validTypes = ['image/png', 'image/jpeg', 'image/jpg'];

                // Check file size
                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'File size exceeds 2MB. Please upload a smaller file.'
                    });
                    event.target.value = ''; // Clear the input
                    return;
                }

                // Check file type
                if (!validTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Invalid file type. Please upload an image file (PNG, JPEG, JPG).'
                    });
                    event.target.value = ''; // Clear the input
                    return;
                }

                // If all checks pass
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'File is valid!'
                });
            }
        });
    </script>
</div>


                        </div>
                        <button class="btn btn-primary w-100 mb-3" type="submit">Sign up</button>
                        <div class="d-flex flex-column align-items-center mb-4"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/three.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/Lightbox-Gallery.js"></script>
    <script src="assets/js/Lightbox-Gallery-baguetteBox.min.js"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        //majors
        document.getElementById('course').addEventListener('change', function() {
            var courseId = this.value;
            console.log("Course ID selected: " + courseId); // Debugging line

            var majorsContainer = document.getElementById('majors-container');
            majorsContainer.innerHTML = ''; // Clear majors container

            if (courseId !== "") {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "functions/get-majors.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        console.log("Response from server: " + xhr.responseText); // Debugging line
                        majorsContainer.innerHTML = xhr.responseText;
                    }
                };
                xhr.send("course_id=" + courseId);
            }
        });

        $(document).ready(function() {
            <?php if (isset($_SESSION['error'])): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?php echo $_SESSION['error']; ?>',
                    confirmButtonText: 'Close'
                });
                <?php unset($_SESSION['error']); // Clear the message after displaying 
                ?>
            <?php endif; ?>
        });


        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const type = urlParams.get('type');
            const message = urlParams.get('message');

            if (type === 'success' && message) {
                showNotification(decodeURIComponent(message));
            }
        };

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.classList.add('notification', 'success');
            notification.textContent = message;

            // Add to the page body
            document.body.appendChild(notification);

            // Auto hide after 5 seconds
            setTimeout(() => {
                notification.style.opacity = 0;
                setTimeout(() => notification.remove(), 500);
            }, 5000);
        }
    </script>
<?php
if(isset($_SESSION['status'])){
    echo "<script>Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '".$_SESSION['message']."',
        confirmButtonText: 'Close'
    });</script>";
    unset($_SESSION['status']);
    unset($_SESSION['message']);
}
if(isset($_SESSION['success'])){
    echo "<script>Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '".$_SESSION['message']."',
        confirmButtonText: 'Close'
    });</script>";
    unset($_SESSION['success']);
    unset($_SESSION['message']);
}
?>
</body>

</html>