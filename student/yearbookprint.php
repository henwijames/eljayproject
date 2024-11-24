<?php
require '../vendor/autoload.php';
include '../functions/conn.php';
$batchid = $_GET['batch'];
use Mpdf\Mpdf;

// Initialize Mpdf with A4 Landscape
$mpdf = new Mpdf([
    'format' => 'A4',
    'orientation' => 'L',

]);




$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }

        .bg-container {
            background-image: url("assets/bgs.png");
            background-size: cover;
            background-repeat: no-repeat;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .wrapper {
            padding: 20px;
        }

        h1, h2 {
            text-align: center;
        }

        .mission-vision {
            text-align: center;
            margin: 20px 0;
        }

        .mission-vision ol, .mission-vision ul {
            list-style-position: inside;
            padding: 0;
            text-align: center;
        }

        .mission-vision ul li {
            text-align: center;
        }

        .course-section {
            page-break-before: always; /* Ensures each course starts on a new page */
            margin-bottom: 40px;
            box-sizing: border-box;
        }

       

        .card {
            width: 20%;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: #f8f9fa;
            margin-bottom: 20px;
        }

        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 1rem;
            text-align: center;
        }

        .card-text {
            font-size: 1rem;
            color: #333;
        }
         
.course-section {
            margin-bottom: 30px;
        }

        .student-cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* Center the cards horizontally */
            gap: 15px; /* Spacing between cards */
            margin: 20px auto;
            max-width: 100%; /* Ensure the container doesn\'t overflow */
        }

        .student-cards-container {
    width: 100%;
    border-collapse: separate;
    border-spacing: 20px; /* Space between cards */
}

.student-card {
    text-align: center;
    vertical-align: top; /* Align cards to the top */
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 50px; /* Fixed width for cards */
}

.student-card img {
    border-radius: 50%;
    width: 50px;
    height: 100px;
    object-fit: cover;
    margin-bottom: 10px;
}

.card-text {
    font-size: 20px;
    font-weight: bold;
    color: #333;
    margin: 0;
}
.card-motto{
    font-size: 15px;
    color: #333;
    margin: 0;
}
  .card-another-bold{
    font-size: 15px;
    color: #333;
    margin: 0;
    font-weight: bold;
    text-transform: uppercase;
    text-decoration: underline;
  }


    </style>
    
</head>
<body>
    <div class="bg-container"></div>
    <div class="wrapper">
        <h1 class="mt-4">Yearbook for Batch</h1>
        <div class="mission-vision mb-4">
            <h2>Vision</h2>
            <p>Expanding the Right Choice for Real-Life Education in Southern Luzon.</p>
            <h2>Mission</h2>
            <ol>
                <li>Provide holistic higher education and technical-vocational programs which are valued by the stakeholders.</li>
                <li>Transform the youth into world-class professionals who creatively respond to the ever-changing world of works.</li>
                <li>Advance research production to improve human life and address societal needs.</li>
                <li>Engage in various projects that aim to build strong community relations and involvement.</li>
                <li>Promote compliance with quality assurance in both service delivery and program development.</li>
            </ol>
            <h2>Core Values</h2>
            <ul>
                <li><strong>L</strong> - Love of God</li>
                <li><strong>C</strong> - Cs (Competent, Committed, and Compassionate) in service</li>
                <li><strong>I</strong> - Innovative Minds</li>
                <li><strong>A</strong> - Aspiring People</li>
                <li><strong>N</strong> - Noble Dreams</li>
            </ul>
        </div>';

$sql = "SELECT * FROM courses";
$coursesResult = $conn->query($sql);


foreach ($coursesResult as $courseRow) {
    $courseId = $courseRow['id'];
    $html .= '
        <div class="course-section">
            <h2>' . htmlspecialchars($courseRow['name']) . '</h2>
            <table class="student-cards-container">
                <tr>
    ';
    
    $studentsSql = "SELECT * FROM alumnigallery WHERE COURSE = '$courseId' AND BATCHDATE = '$batchid'";
    $studentsResult = mysqli_query($conn, $studentsSql);

    if (mysqli_num_rows($studentsResult) > 0) {
        $counter = 0; // Track the number of cards in a row
        while ($studentRow = mysqli_fetch_assoc($studentsResult)) {
            $html .= '
    <td class="student-card">
        <img src="images/' . htmlspecialchars($studentRow['IMAGE']) . '" alt="Student Image">
        <div class="card-body">
            <p class="card-text">';
                if ($studentRow['MIDDLENAME'] == '') {
                    $html .= htmlspecialchars($studentRow['LASTNAME'] . ' ' . $studentRow['FIRSTNAME']);
                } else {
                    $html .= htmlspecialchars($studentRow['LASTNAME'] . ' ' . $studentRow['FIRSTNAME'] . ' ' . $studentRow['MIDDLENAME'][0] . '.');
                }
                $achid = $studentRow['ACHIEVEMENT_ID'];
                $achsql = "SELECT * FROM achievements WHERE ID = $achid";
                $achresult = mysqli_query($conn, $achsql);
                $achrow = mysqli_fetch_assoc($achresult);
                $html .= '
                            </p>
                            <p class="card-motto"><i>&quot;' . htmlspecialchars($studentRow['MOTTO']) . '&quot;</i></p>
                            <p class="card-another">' . htmlspecialchars($studentRow['BIRTHDATE']) . '</p>
                            <p class="card-another">' . htmlspecialchars($studentRow['ADDRESS']) . '</p>
                        ';
                        $html .= '
                            <p class="card-another-bold">' . htmlspecialchars($achrow['name']) . '</p>   
                        </div>
                    </td>
                ';


            $counter++;
            // Break the row after every 4 cards
            if ($counter % 5 == 0) {
                $html .= '</tr><tr>';
            }
        }
    } else {
        $html .= '
            <td colspan="4" style="text-align: center; font-weight: bold;">
                No students found
            </td>
        ';
    }

    $html .= '
                </tr>
            </table>
        </div>
    ';  // Close the course section
}


$html .= '
    </div>
</body>
</html>';

// Write the HTML content
$mpdf->WriteHTML($html);

// Output the PDF
$mpdf->Output('loan_receipt.pdf', 'I');
$achid = $studentRow['ACHIEVEMENT_ID'];
$achsql = "SELECT * FROM achievements WHERE ID = $achid";
$achresult = mysqli_query($conn, $achsql);
$achrow = mysqli_fetch_assoc($achresult);
echo $achrow['name'];

?>